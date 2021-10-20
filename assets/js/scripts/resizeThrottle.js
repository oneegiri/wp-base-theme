var resizeId;
window.addEventListener('resize', function() {
    clearTimeout(resizeId);
    resizeId = setTimeout(doneResizing, 500);
});

function doneResizing(){
    //whatever we want to do
}