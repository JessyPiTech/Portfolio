const waypoints = [ 
    { scrollY: 30, x: 1400, y: 0, action: 'raiseLeftFist' },   
    { scrollY: 300, x: 290, y: 150, action: 'raiseRightFist' },
    { scrollY: 400, x: 300, y: 250, action: 'waveBothArms' }, 
    { scrollY: 900, x: 500, y: 400, action: 'reset' } 
];

const pathConfig = {
    type: 'sine',
    amplitude: 150,
    frequency: 0.5,
    verticalOffset: 100,
    margin: 30,
};

const stickFigure = document.querySelector('.stick-figure');
    let currentPosition = { x: 0, y: 0 };
    let scrollTimeout; 

    stickFigure.addEventListener('click', () => {
    alert("ne touche pas au guide");
});

function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}


function calculatePathPosition(scrollY) {
    for (let i = 0; i < waypoints.length - 1; i++) {
        const pointA = waypoints[i];
        const pointB = waypoints[i + 1];

        if (scrollY >= pointA.scrollY && scrollY <= pointB.scrollY) {
        return interpolatePoints(scrollY, pointA, pointB);
        }
    }

    if (scrollY < waypoints[0].scrollY) return waypoints[0];
    if (scrollY > waypoints[waypoints.length - 1].scrollY) return waypoints[waypoints.length - 1];
}

function interpolatePoints(currentScroll, pointA, pointB) {
    const progress = (currentScroll - pointA.scrollY) / (pointB.scrollY - pointA.scrollY);
    const x = pointA.x + (pointB.x - pointA.x) * progress;
    const y = pointA.y + (pointB.y - pointA.y) * progress;
    return { x, y };
}

function startMoving() {
    const leg_left = document.querySelector('.leg-left');
    const leg_right = document.querySelector('.leg-right');
    const arm_left = document.querySelector('.arm-left');
    const arm_right = document.querySelector('.arm-right');

    leg_left.style.animation = 'swingLegLeft 0.5s linear infinite';
    leg_right.style.animation = 'swingLegRight 0.5s linear infinite';
    arm_left.style.animation = 'swingArmLeft 0.5s linear infinite';
    arm_right.style.animation = 'swingArmRight 0.5s linear infinite';
}

function stopMoving() {
    const leg_left = document.querySelector('.leg-left');
    const leg_right = document.querySelector('.leg-right');
    const arm_left = document.querySelector('.arm-left');
    const arm_right = document.querySelector('.arm-right');

    leg_left.style.animation = '';
    leg_right.style.animation = '';
    arm_left.style.animation = '';
    arm_right.style.animation = '';
}

function updatePosition() {
    const scrollY = window.scrollY;
    const pos = calculatePathPosition(scrollY);
    const nextPos = calculatePathPosition(scrollY + 1);
    const direction = nextPos.x > pos.x ? 1 : -1;

    currentPosition = pos;
    stickFigure.style.transform = `translate(${pos.x}px, ${pos.y}px) scaleX(${direction})`;

    // i a un probleme va falloir definir des zones pas des points
    waypoints.forEach((waypoint, index) => {
        if (Math.abs(scrollY - waypoint.scrollY) < 5) {
            handleSpecialPoint(index);
        }
    });
}

function handleScroll() {
    startMoving(); 
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        stopMoving();
    }, 500); 
}

function handleSpecialPoint(index) {
    const arm_left = document.querySelector('.arm-left');
    const arm_right = document.querySelector('.arm-right');

    const action = waypoints[index].action;

    switch (action) {
        case 'raiseLeftArm':
            arm_left.style.animation = 'raiseArm 1s ease forwards';
            arm_right.style.animation = ''; 
            break;

        case 'raiseRightArm':
            arm_right.style.animation = 'raiseArm 1s ease forwards';
            arm_left.style.animation = ''; 
            break;

        case 'raiseLeftFist':
            arm_left.style.animation = 'raiseFist 1s ease forwards';
            arm_right.style.animation = '';
            break;

        case 'raiseRightFist':
            arm_right.style.animation = 'raiseFist 1s ease forwards';
            arm_left.style.animation = '';
            break;

        case 'waveBothArms':
            arm_left.style.animation = 'swingArmLeft 0.5s linear infinite';
            arm_right.style.animation = 'swingArmRight 0.5s linear infinite';
            break;

        case 'reset':
            arm_left.style.animation = '';
            arm_right.style.animation = '';
            break;

        default:
            break;
    }
}
window.addEventListener('scroll', () => {
    requestAnimationFrame(() => {
        updatePosition();
        handleScroll();
    });
});

window.addEventListener('resize', () => {
    requestAnimationFrame(updatePosition);
});

updatePosition();