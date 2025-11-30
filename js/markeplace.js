document.addEventListener('DOMContentLoaded', () => {

    const actionButtons = document.querySelectorAll('[data-action="buy"], [data-action="register"]');

    actionButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const user = localStorage.getItem('ecotrade_session_user');
            
            if (!user) {
                
                const actionType = button.getAttribute('data-action');
                let message = '';
                
                if (actionType === 'buy') {
                    message = 'Para realizar a compra de créditos, você precisa estar logado(a).';
                } else if (actionType === 'register') {
                    message = 'Para registrar créditos para venda, faça o login como Produtor.';
                }
                
                alert(message);
            } else {
                const userObj = JSON.parse(user);
                
                if (button.getAttribute('data-action') === 'buy' && userObj.tipo !== 'empresa') {
                    alert('Apenas Empresas Compradoras podem realizar compras.');
                } else if (button.getAttribute('data-action') === 'register' && userObj.tipo !== 'produtor') {
                    alert('Apenas Produtores Rurais podem registrar créditos.');
                } else {
                    alert(`Ação de ${button.textContent} liberada para ${userObj.nome}!`);
                }
            }
        });
    });
});