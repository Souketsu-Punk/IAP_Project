//JS for dynamic features
document.addEventListener("DOMContentLoaded", function(){

    // Confirm exchange actions
    const exchangeLinks = document.querySelectorAll('a[href*="accept_request.php"], a[href*="complete_exchange.php"]');
    exchangeLinks.forEach(link => {
        link.addEventListener('click', function(e){
            if(!confirm("Are you sure you want to perform this action?")){
                e.preventDefault();
            }
        });
    });

    //Search/filter on skill cards
    const searchInput = document.getElementById('searchInput');
    if(searchInput){
        searchInput.addEventListener('keyup', function(){
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('.skill-card');
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                if(title.includes(query)){
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

});
