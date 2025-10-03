//----------------  VALIDAÇÃO CEP  -----------------//

function buscarcep() {
  
    let cep = document.getElementById("cep").value;  
    let msgErro = document.querySelector('#msgErro');
    
    if (cep !== " ") {
      let url = "https://brasilapi.com.br/api/cep/v1/" + cep;
  
      let req = new XMLHttpRequest();
      req.open("GET", url);
      req.send();
  
      req.onload = function() {
  
        if (req.status === 200) {
          msgErro.setAttribute('style', 'display: none');
          let endereco = JSON.parse(req.response);
          document.getElementById("endereco").value = endereco.street;
          document.getElementById("bairro").value = endereco.neighborhood;
          document.getElementById("cidade").value = endereco.city;
          document.getElementById("estado").value = endereco.state;
        }
  
        else if (req.status === 404) {
          msgErro.setAttribute('style', 'display: block');
          msgErro.innerHTML = "CEP não encontrado."
          //alert("CEP não encontrado");
        }
        else {
          msgErro.setAttribute('style', 'display: block');
          msgErro.innerHTML = "Erro ao fazer requisição."
          //alert("Erro ao fazer requisição");
        }
      }
    }
  }
  
  window.onload = function() {
    let cep = document.getElementById("cep");
    cep.addEventListener("blur", buscarcep);
  
    submit.addEventListener("click", function() {
      let numero = document.getElementById("numero").value;
      let cep = document.getElementById("cep").value;
  
          if (numero === "") {
          
          }
            else if (cep === ""){
              
            }
            
            else {
            window.location.href = "cadastro3.html";
          }
        });
      }
  //---------------  VALIDAÇÃO CEP  ----------------//