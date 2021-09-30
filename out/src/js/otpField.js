const $otp_length = 6;

const element = document.getElementById('OTPInput');
for (let i = 0; i < $otp_length; i++) {
    let inputField = document.createElement('input'); // Creates a new input element
    inputField.className = " w-12 h-12 bg-light border-gray-50 outline-none form-control m-2 text-center rounded";
    inputField.style.cssText = "color: transparent; text-shadow: 0 0 0 gray;";
    inputField.id = 'otp-field' + i;
    inputField.maxLength = 1;
    element.appendChild(inputField);
}

const inputs = document.querySelectorAll('#OTPInput > *[id]');
inputs[0].focus();
for (let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('keydown', function (event) {
        if (event.key === "Backspace") {
            inputs[i].value = '';
            if (i !== 0) {
                inputs[i - 1].focus();
            }
        } else if (event.key === "ArrowLeft" && i !== 0) {
            inputs[i - 1].focus();
        } else if (event.key === "ArrowRight" && i !== inputs.length - 1) {
            inputs[i + 1].focus();
        }
    });
    inputs[i].addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        if (i === inputs.length - 1 && inputs[i].value !== '') {
            return true;
        } else if (inputs[i].value !== '') {
            inputs[i + 1].focus();
        }
    });

}

document.getElementById('accUserSaveTop').addEventListener("click", function () {
    const inputs = document.querySelectorAll('#OTPInput > *[id]');
    let compiledOtp = '';
    for (let i = 0; i < inputs.length; i++) {
        compiledOtp += inputs[i].value;
    }
    document.getElementById('otp').value = compiledOtp;
    return true;
});