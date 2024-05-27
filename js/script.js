// side bar
const sidebarToggle = document.querySelector('#sidebar-toggle');
sidebarToggle.addEventListener('click', function(){
    document.querySelector('#sidebar').classList.toggle("collapsed");
})

function changePage(page){
    var hidden = document.querySelectorAll('.hidden');
    hidden.forEach(function(hide){
        hide.classList.remove('dashactive');
    });

    var activePage = document.getElementById(page);
    activePage.classList.add('dashactive');
}

