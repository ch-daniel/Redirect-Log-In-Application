function eyeClick(e) {
    inpt = e.previousElementSibling;
    if (e.src.includes("eye-opened")) {
        e.src = "/eye-closed.png";
        inpt.type = "password";
    } else 
    {
        e.src = "/eye-opened.png";
        inpt.type = "text";
    }
}


setTimeout(() => {
    if (document.querySelector(".success-alert-box")) {
        setTimeout(() => {
            document.querySelector(".success-alert-box").style.visibility = "hidden"; 
          }, "1000")
    }
  }, "1000")


function onlyNumberKey(evt) {
    // Only ASCII character in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
    return false;
    return true;
}