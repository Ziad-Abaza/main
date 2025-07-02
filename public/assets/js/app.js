document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".auto-hide");

    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";

            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    const modalImage = document.getElementById("modalImage");

    // Add click event listener to all images with data-image attribute
    document
        .querySelectorAll('img[data-bs-target="#imageModal"]')
        .forEach((img) => {
            img.addEventListener("click", function () {
                const imageUrl = this.getAttribute("data-image");
                modalImage.src = imageUrl;
            });
        });

    // Handle full description modal
    const fullDescription = document.getElementById("fullDescription");
    document.querySelectorAll(".show-full-description").forEach((link) => {
        link.addEventListener("click", function () {
            const description = this.getAttribute("data-description");
            fullDescription.textContent = description;
        });
    });

    document
        .getElementById("searchInput")
        .addEventListener("input", function () {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll(".searchable-item");

            items.forEach((item) => {
                let text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "" : "none";
            });
        });

});
