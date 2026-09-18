"""HTTP publication smoke check; stdlib only. Pass the site base URL."""
from pathlib import Path
from urllib.request import urlopen
from urllib.error import HTTPError
from html.parser import HTMLParser
import hashlib
import json
import re
import sys

class Page(HTMLParser):
    def __init__(self, html):
        super().__init__()
        self.links = []
        self.text = []
        self.feed(html)
    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        if tag == 'a' and 'href' in attrs:
            self.links.append(attrs['href'])
    def handle_data(self, data):
        self.text.append(data)

base = sys.argv[1].rstrip('/') + '/'
root = Path(__file__).resolve().parents[1] / 'legal-documents'
manifest = json.loads((root / 'manifest.json').read_text(encoding='utf-8'))
urls = {base}
normalize = lambda text: re.sub(r'\s+', '', text).replace('–', '-').replace('—', '-')
for document in manifest:
    with urlopen(base + document['slug'] + '/', timeout=30) as response:
        page = Page(response.read().decode('utf-8'))
    original = Page((root / document['html']).read_text(encoding='utf-8'))
    assert normalize(''.join(original.text)) in normalize(''.join(page.text)), 'Document text mismatch'
    assert not any(url.endswith(('.pdf', '.docx')) for url in page.links), 'Unexpected download link'
    assert not any(text.strip() == 'в ИП МЯСНИКОВ КИРИЛЛ ЛЬВОВИЧ' for text in page.text), 'Unexpected subtitle'
    for expected in document['files'].values():
        try:
            urlopen(base + 'wp-content/uploads/2026/09/' + expected['name'], timeout=30)
            raise AssertionError('Old public document still accessible')
        except HTTPError as error:
            assert error.code in (404, 410)
    urls.update(url for url in page.links if url.startswith(base) and '/wp-content/' not in url)
    print(document['slug'] + ': text MATCH; download links absent; old public files unavailable')
for url in sorted(urls):
    with urlopen(url, timeout=30) as response:
        assert response.status == 200
try:
    urlopen(base + 'legal-document-check-missing/', timeout=30)
    raise AssertionError('Expected 404')
except HTTPError as error:
    assert error.code == 404
print(str(len(urls)) + ' internal links OK; 404 OK')
