
  const params = new URLSearchParams(window.location.search);
  const messageBox = document.getElementById('floatingMessage');
  const messageText = document.getElementById('messageText');

  function showMessage(text, color) {
    messageText.textContent = text;
    messageBox.style.backgroundColor = color;
    messageBox.style.display = 'block';

    setTimeout(() => {
      messageBox.style.display = 'none';
    }, 3000);
  }

  if (params.has('entry')) {
    const name = decodeURIComponent(params.get('entry'));
    showMessage(`${name} entered the library.`, '#4caf50'); // Green
  }

  if (params.has('exit')) {
    const name = decodeURIComponent(params.get('exit'));
    showMessage(`${name} exited the library.`, '#2196f3'); // Blue
  }

  if (params.has('error')) {
    showMessage(`❌ Please check the registration number.`, '#f44336'); // Red
  }

  // Optional: Clear URL parameters after showing message
  if (params.has('entry') || params.has('exit') || params.has('error')) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }

