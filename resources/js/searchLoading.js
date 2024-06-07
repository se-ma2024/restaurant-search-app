function searchLoading() {
    const overlay = document.getElementById("loading-overlay");
    const handle = document.querySelector(".handle");
    let rotation = 0;
    let handle_rotate = 10;

    overlay.style.display = "flex";

    for (let i = 0; i < handle_rotate; i++) {
        setTimeout(() => {
            rotation += 120;
            handle.style.transform = `rotate(${rotation}deg)`;
        }, i * 1000);
    }
}
