function validate(evt) {
    let theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        let key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    let regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

const dialog = document.querySelector("dialog")

dialog.addEventListener("click", e => {
    const dialogDimensions = dialog.getBoundingClientRect()
    if (
        e.clientX < dialogDimensions.left ||
        e.clientX > dialogDimensions.right ||
        e.clientY < dialogDimensions.top ||
        e.clientY > dialogDimensions.bottom
    ) {
        dialog.close()
    }
})