const track = document.querySelector('.carousel-track');


function duplicateIcons() {
    const icons = [...track.children];
    icons.forEach(icon => {
        const clone = icon.cloneNode(true);
        track.appendChild(clone);
    });
}

duplicateIcons();
duplicateIcons();


document.addEventListener('DOMContentLoaded', () => {
    const skillLevels = document.querySelectorAll('.skill-level');
    
    skillLevels.forEach(level => {
      const targetWidth = level.style.width;
      level.style.width = '0';
      
      setTimeout(() => {
        level.style.width = targetWidth;
      }, 200);
    });
});
