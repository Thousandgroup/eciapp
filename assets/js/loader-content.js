// === Loader khusus content-wrapper AdminLTE === //

function showContentLoader(message = 'Loading...') {
  const overlay = document.getElementById('content-loading-overlay');
  const text = document.getElementById('content-loading-text');
  if (overlay) {
    overlay.style.display = 'flex';
    text.textContent = message;
  }
}

function hideContentLoader() {
  const overlay = document.getElementById('content-loading-overlay');
  if (overlay) overlay.style.display = 'none';
}

// Sembunyikan loader otomatis saat halaman selesai dimuat
window.addEventListener('load', hideContentLoader);

// Aktifkan loader otomatis untuk form di dalam content-wrapper
document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('.content-wrapper form');
  forms.forEach(form => {
    form.addEventListener('submit', () => {
      showContentLoader('Saving Data...');
    });
  });
});

document.addEventListener('click', function(e) {
  const target = e.target.closest('a');
  if (target && target.getAttribute('href') && !target.getAttribute('target')) {
    const href = target.getAttribute('href');
    if (href && !href.startsWith('#') && !href.startsWith('javascript')) {
      showContentLoader('Loading...');
    }
  }
});
