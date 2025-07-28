const params = new URLSearchParams(window.location.search);

  // ✅ Entry alert
  if (params.has('entry')) {
    alert(`${decodeURIComponent(params.get('entry'))} entered the library.`);
  }

  // ✅ Exit alert
  if (params.has('exit')) {
    alert(`${decodeURIComponent(params.get('exit'))} exited the library.`);
  }

  // ✅ Invalid number error
  if (params.has('error')) {
    const errBox = document.getElementById('errorMessage');
    errBox.style.display = 'block';
    setTimeout(() => errBox.style.display = 'none', 2000);
  }

  // ✅ Clean URL (remove ?entry/exit/error after showing)
  if (params.has('entry') || params.has('exit') || params.has('error')) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }