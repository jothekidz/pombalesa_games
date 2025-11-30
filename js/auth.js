document.addEventListener('DOMContentLoaded', () => {

    const formCadastro = document.getElementById('form-cadastro');
    if (formCadastro) {

        formCadastro.addEventListener('submit', (event) => {
            event.preventDefault();
            
            const dados = {
                tipo: formCadastro['tipo-usuario'].value,
                nome: formCadastro['nome'].value,
                email: formCadastro['email'].value,
                senha: formCadastro['senha'].value,
            };

            let usuarios = JSON.parse(localStorage.getItem('ecotrade_usuarios')) || [];
            if (usuarios.some(u => u.email === dados.email)) {
                alert('Erro: Este e-mail já está cadastrado!');
                return;
            }

            usuarios.push(dados);
            localStorage.setItem('ecotrade_usuarios', JSON.stringify(usuarios));
            
            alert(`Cadastro de ${dados.tipo} realizado com sucesso! Agora faça o login.`);
            window.location.href = 'login.html';
        });
    }
    const formLogin = document.getElementById('form-login');
    if (formLogin) {
        const loginMessage = document.getElementById('login-message');
        
        formLogin.addEventListener('submit', (event) => {
            event.preventDefault();
            
            const email = formLogin['email-login'].value;
            const senha = formLogin['senha-login'].value;
            
            let usuarios = JSON.parse(localStorage.getItem('ecotrade_usuarios')) || [];
            
            const usuarioEncontrado = usuarios.find(u => u.email === email && u.senha === senha);

            if (usuarioEncontrado) {
                localStorage.setItem('ecotrade_session_user', JSON.stringify(usuarioEncontrado));
                
                let redirectURL = '';
                switch (usuarioEncontrado.tipo) {
                    case 'produtor':
                        redirectURL = 'dashboard-produtor.html';
                        break;
                    case 'empresa':
                        redirectURL = 'dashboard-empresa.html';
                        break;
                    case 'administrador':
                        redirectURL = 'dashboard-admin.html';
                        break;
                    default:
                        redirectURL = 'marketplace.html';
                }
                
                loginMessage.textContent = 'Login bem-sucedido! Redirecionando...';
                loginMessage.style.color = 'green';
                window.location.href = redirectURL;
                
            } else {
                loginMessage.textContent = 'Erro: E-mail ou senha incorretos.';
                loginMessage.style.color = 'red';
            }
        });
    }
});