"""Convert supplied DOCX text to HTML in document order; retain original downloads."""
from pathlib import Path
from html import escape
import hashlib
import json
import re
import shutil
from docx import Document
from docx.table import Table
from docx.text.paragraph import Paragraph
from pypdf import PdfReader

source = Path.home() / 'Downloads'
destination = Path(__file__).resolve().parents[1] / 'legal-documents'
destination.mkdir(exist_ok=True)
specs = [
    ('POLITIKA_V_OTNOShENII_OBRABOTKI_PDn', 'privacy-policy', 'Политика в отношении обработки персональных данных', 'Политика обработки персональных данных'),
    ('Soglasie_na_obrabotku_personalnykh_dannykh', 'personal-data-consent', 'Согласие на обработку персональных данных', 'Согласие на обработку персональных данных'),
]
manifest = []
for stem, slug, title, label in specs:
    doc = Document(source / (stem + '.docx'))
    pdf_text = re.sub(r'\s+', '', ''.join(page.extract_text() for page in PdfReader(source / (stem + '.pdf')).pages))
    pdf_position = 0
    blocks = []
    for element in doc.element.body:
        if element.tag.endswith('}p'):
            paragraph = Paragraph(element, doc)
            text = paragraph.text.strip()
            if not text or text == title:
                continue
            if slug == 'privacy-policy' and text == 'в ИП МЯСНИКОВ КИРИЛЛ ЛЬВОВИЧ':
                continue
            needle = re.sub(r'\s+', '', text)[:60]
            position = pdf_text.find(needle, pdf_position)
            numbering = paragraph._p.pPr.numPr if paragraph._p.pPr is not None else None
            if numbering is not None:
                if position < 0:
                    raise ValueError('Cannot verify numbering against PDF: ' + text[:80])
                prefix = re.search(r'(\d+(?:\.\d+)*[.)]?|[\uf02d\u2022-])$', pdf_text[max(0, position - 20):position])
                if not prefix:
                    raise ValueError('Missing PDF list prefix: ' + text[:80])
                label_prefix = prefix.group(0).replace('\uf02d', '–')
                text = label_prefix + ' ' + text
            if position >= 0:
                pdf_position = position + len(needle)
            heading = bool(re.match(r'^\d+\.\s+[^\d]', text)) and len(text) < 180
            tag = 'h2' if heading or text == 'Приложение' else 'p'
            blocks.append(f'<{tag}>{escape(text).replace(chr(10), "<br>")}</{tag}>')
        elif element.tag.endswith('}tbl'):
            rows = []
            for i, row in enumerate(Table(element, doc).rows):
                tag = 'th' if i == 0 else 'td'
                scope = ' scope="col"' if i == 0 else ''
                rows.append('<tr>' + ''.join(f'<{tag}{scope}>{escape(cell.text).replace(chr(10), "<br>")}</{tag}>' for cell in row.cells) + '</tr>')
            blocks.append('<div class="vr-legal-table" role="region" aria-label="Таблица из документа" tabindex="0"><table><tbody>' + ''.join(rows) + '</tbody></table></div>')
    (destination / (slug + '.html')).write_text('\n'.join(blocks) + '\n', encoding='utf-8')
    files = {}
    for extension in ['pdf', 'docx']:
        target = destination / (slug + '.' + extension)
        shutil.copyfile(source / (stem + '.' + extension), target)
        files[extension] = {'name': target.name, 'sha256': hashlib.sha256(target.read_bytes()).hexdigest()}
    manifest.append({'slug': slug, 'title': title, 'menu_label': label, 'description': title + ' ИП Мясникова Кирилла Львовича. Полный текст документа.', 'html': slug + '.html', 'publish_downloads': False, 'files': files})
    print(slug, len(blocks), 'blocks', len(doc.tables), 'tables')
(destination / 'manifest.json').write_text(json.dumps(manifest, ensure_ascii=False, indent=2) + '\n', encoding='utf-8')
