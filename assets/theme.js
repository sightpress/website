(function () {
  var root = document.documentElement;
  var key = 'sp-color-scheme';
  var stored = null;
  try { stored = localStorage.getItem(key); } catch (e) {}
  root.setAttribute('data-color-scheme', stored === 'light' ? 'light' : 'dark');

  document.addEventListener('DOMContentLoaded', function () {
    var button = document.getElementById('theme-toggle');
    if (!button) { return; }

    function render() {
      var dark = root.getAttribute('data-color-scheme') === 'dark';
      button.textContent = button.getAttribute(dark ? 'data-label-light' : 'data-label-dark');
      var meta = document.querySelector('meta[name="theme-color"]');
      if (meta) { meta.setAttribute('content', dark ? '#101430' : '#3D2FC4'); }
    }

    button.hidden = false;
    render();
    button.addEventListener('click', function () {
      var next = root.getAttribute('data-color-scheme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-color-scheme', next);
      try { localStorage.setItem(key, next); } catch (e) {}
      render();
    });
  });
}());
