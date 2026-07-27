(function ($) {
  'use strict';

  $(document).on('click', '.vr-theme-media__select', function (event) {
    event.preventDefault();

    var container = $(this).closest('.vr-theme-media');
    var input = container.find('input[type="hidden"]');
    var preview = container.find('.vr-theme-media__preview-wrap');
    var frame = wp.media({
      title: container.data('title'),
      button: { text: container.data('button') },
      library: { type: 'image' },
      multiple: false
    });

    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      var image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
      input.val(attachment.id);
      preview.html($('<img>', { class: 'vr-theme-media__preview', src: image, alt: '' }));
    });

    frame.open();
  });

  $(document).on('click', '.vr-theme-media__remove', function (event) {
    event.preventDefault();
    var container = $(this).closest('.vr-theme-media');
    container.find('input[type="hidden"]').val('');
    container.find('.vr-theme-media__preview-wrap').empty();
  });
})(jQuery);
