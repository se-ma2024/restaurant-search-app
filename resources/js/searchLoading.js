function searchLoading() {
    const overlay = document.getElementById("loading-overlay");
    const handle = document.querySelector(".handle");
    let rotation = 0;

    overlay.style.display = "flex";

    for (let i = 0; i < 3; i++) {
        setTimeout(() => {
            rotation += 120;
            handle.style.transform = `rotate(${rotation}deg)`;
        }, i * 1000);
    }
}
