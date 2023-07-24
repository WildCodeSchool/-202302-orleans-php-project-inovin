for (let i = 1; i <= 3; i++) {
    
    const nextButton = document.getElementById('pills-next-'+i);
    const beforeButton = document.getElementById('pills-before-'+(i+1));

    const navbarPillCurrent = document.getElementById('pills-tab-'+i);
    const tabContentCurrent = document.getElementById('pills-'+ i);

    const navbarPillNext = document.getElementById('pills-tab-'+(i+1));
    const tabContentNext = document.getElementById('pills-'+(i+1));

    nextButton.addEventListener('click', event => {
        event.preventDefault();
        navbarPillCurrent.classList.remove('active');
        navbarPillNext.classList.add('active');
        tabContentCurrent.classList.remove('active', 'show');
        tabContentNext.classList.add('active', 'show');
        window.top.window.scrollTo(0,0);
    })

    beforeButton.addEventListener('click', event => {
        event.preventDefault();
        navbarPillNext.classList.remove('active');
        navbarPillCurrent.classList.add('active');
        tabContentNext.classList.remove('active', 'show');
        tabContentCurrent.classList.add('active', 'show');
        window.top.window.scrollTo(0,0);
    })
}