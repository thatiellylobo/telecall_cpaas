document.addEventListener('DOMContentLoaded', function () {
    const visualizarLinks = document.querySelectorAll('.visualizar');
    const modal = document.getElementById('modal');
    const clienteInfo = document.getElementById('cliente-info');
    const closeBtn = document.querySelector('.close');
    
    visualizarLinks.forEach(function (link) {
        
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const idCliente = this.getAttribute('data-id');

            // Realizar requisição AJAX para obter os dados do cliente com ID igual a idCliente
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'dados_cliente.php?id=' + idCliente, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);

                    clienteInfo.innerHTML = `
                    <strong class="cliente-info">Nome: </strong> <br>${response.nome}<br><br>
                    <Strong class="cliente-info">Data de Nascimento: </strong><br>${response.nascimento}<br><br>
                    <strong class="cliente-info">Nome Materno: </strong><br>${response.nome_materno}</br><br>
                    <strong class="cliente-info">CPF: </strong><br>${response.cpf}<br><br>
                    <strong class="cliente-info">Celular: </strong><br>${response.celular}<br><br>
                    <strong class="cliente-info">Email: </strong><br>${response.email}<br><br>
                    <strong class="cliente-info">Login: </strong><br>${response.userCad}</br><br>
                    <strong class="cliente-info">CEP: </strong><br>${response.cep}</br><br>
                    <strong class="cliente-info">Endereço: </strong><br>${response.endereco}, ${response.numero} - ${response.bairro}<br><br>
                    <strong class="cliente-info">Cidade/Estado: </strong><br>${response.cidade}/${response.estado}<br><br>
                    `;
                    clienteInfo.classList.add('cliente-info');

                    const excluirBtn = document.createElement('button');
                    excluirBtn.textContent = 'Excluir Usuário';
                    excluirBtn.classList.add('excluir-btn'); 

                    clienteInfo.appendChild(excluirBtn);

                    excluirBtn.addEventListener('click', function () {
                        const confirmarExclusao = confirm('Tem certeza que deseja excluir este usuário?');
                    
                        if (confirmarExclusao) {
                            const xhrExcluir = new XMLHttpRequest();
                    
                            xhrExcluir.open('POST', 'excluir_cliente.php?id=' + idCliente, true);
                    
                            xhrExcluir.onload = function () {
                                if (xhrExcluir.status >= 200 && xhrExcluir.status < 300) {
                                    window.location.reload();
                                    modal.style.display = 'none';
                                } else {
                                    alert('Erro ao excluir usuário. Por favor, tente novamente.');
                                }
                            };
                    
                            xhrExcluir.send();
                        }
                    });

                    modal.style.display = 'block';
                } else {
                    console.error('Erro na requisição AJAX');
                }
            };

            xhr.send();
        });
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });
});