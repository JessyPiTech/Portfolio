class ImageGallery {
    constructor(images) {
        this.images = images;
        this.currentIndex = 0;
        this.mainImage = document.querySelector('.main-image');
        this.prevButton = document.getElementById('bouton-l');
        this.nextButton = document.getElementById('bouton-r');
        this.thumbnailsContainer = document.querySelector('.thumbnails-container');

        this.init();
    }

    init() {
        this.updateMainImage();
        this.createThumbnails();
        
        this.prevButton.addEventListener('click', () => this.prevImage());
        this.nextButton.addEventListener('click', () => this.nextImage());
    }

    updateMainImage() {
        this.mainImage.src = this.images[this.currentIndex];
        this.updateThumbnailsState();
    }

    createThumbnails() {
        this.thumbnailsContainer.innerHTML = '';
        this.images.forEach((img, index) => {
            const thumbnail = document.createElement('img');
            thumbnail.src = img;
            thumbnail.alt = `Vignette ${index + 1}`;
            thumbnail.className = `thumbnail ${index === this.currentIndex ? 'active' : ''}`;
            
            thumbnail.addEventListener('click', () => {
                this.currentIndex = index;
                this.updateMainImage();
            });
            
            this.thumbnailsContainer.appendChild(thumbnail);
        });
    }

    updateThumbnailsState() {
        const thumbnails = this.thumbnailsContainer.querySelectorAll('.thumbnail');
        thumbnails.forEach((thumb, index) => {
            thumb.classList.toggle('active', index === this.currentIndex);
        });
    }

    prevImage() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        this.updateMainImage();
    }

    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.updateMainImage();
    }
}


const gallery = new ImageGallery(images);