for (let i = 1; i <= 3; i++) {
    
    const nextButton = document.getElementById('pills-next-'+i);

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
}
