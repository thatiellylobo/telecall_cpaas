//----------------  VALIDAÇÃO  ----------------// 

class Validator {

  constructor() {
    this.validations = [
      'data-required',
      'data-only-letters',
      'data-min-length',
      'data-max-length',
      'data-equal',
      'data-email',
    ];
  }


  //iniciar a validação de todos os campos
  validate(form) {

    //resgata todas as validações
    let currentValidations = document.querySelectorAll('form .erro-validacao');

    if (currentValidations.length > 0) {
      this.cleanValidations(currentValidations);
    }

    //pegar os inputs
    let inputs = form.getElementsByTagName('input');

    // transformo uma HTMLCollections -> array
    let inputsArray = [...inputs];


    //loop nos inputs e validação mediante ao que for encontrado
    inputsArray.forEach(function(input) {

      //loop em todas as validações existentes.
      for (let i = 0; this.validations.length > i; i++) {
        //verifica se a validação atual existe no input
        if (input.getAttribute(this.validations[i]) != null) {

          //limpando a string para virar um método
          let method = this.validations[i].replace('data-', '').replace('-', '');

          //valor input
          let value = input.getAttribute(this.validations[i]);

          //invocar o método
          this[method](input, value);
        }
      }
      
      if (input.type === 'radio') {
        this.radioRequired(input);
      }


      // Adicionar event listener para o evento blur
  input.addEventListener('blur', () => {
    this.cleanValidations([input.parentNode.querySelector('.erro-validacao')]);
  });


    }, this);

  }

  //verifica se o input é requerido
  required(input) {

    let inputValue = input.value;

    if (inputValue === '') {
      let msgerro = `Esse campo é obrigatório.`;

      this.printMensagem(input, msgerro);
    }
  }
  
  //verifica se o input do tipo radio foi selecionado
  radioRequired(input) {
    let radio = form.querySelector(`input[name="${input.name}"]:checked`);
    if (!radio) {
      let msgerro;
      if (input.value !== "Prefiro não responder" && input.value !=="Masculino") {
        msgerro = `Escolha uma opção`;
      }
      this.printMensagem(input, msgerro);
    }
  }
  
  //valida se o campo tem somente letras
  onlyletters(input) {

    let re =  /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/;

      
    let inputValue = input.value;

    let msgerro = `O campo precisa ter somente letras.`;

    if (!re.test(inputValue)) {
      this.printMensagem(input, msgerro);
    }
  }


  //verifica se o input tem o número mínimo de caracteres
  minlength(input, minValue) {

    let inputLength = input.value.length;

    let msgerro = `O campo precisa ter pelo menos ${minValue} caracteres.`;

    if (inputLength < minValue) {
      this.printMensagem(input, msgerro);
    }
  }

  //verifica se um input tem o número máximo de caracteres
  maxlength(input, maxValue) {

    let inputLength = input.value.length;

    let msgerro = `O campo precisa ter menos que ${maxValue} caracteres.`;

    if (inputLength > maxValue) {
      this.printMensagem(input, msgerro);
    }
  }

  //verifica se dois campos são iguais
  equal(input, inputName) {

    let inputToCompare = document.getElementsByName(inputName)[0];

    let msgerro = `Esse campo precisa está igual a senha`;

    if (input.value != inputToCompare.value) {
      this.printMensagem(input, msgerro);
    }
  }

  email(input) {
    let emailValue = input.value;
    let re = /\S+@\S+\.\S+/;
    let msgerro = `E-mail inválido`;

    if (!re.test(emailValue)) {
      this.printMensagem(input, msgerro);
    }
    document.getElementById('email').addEventListener('blur', function() {
      let email = this.value;
      if (!validateEmail(email)) {
        alert('Email inválido');
        this.value = ''; // Limpar o campo de email
      }
    });
  }

  //imprime mensagem de erro na tela.
  printMensagem(input, msg) {

    //quantidade de erros.
    let qtderros = input.parentNode.querySelector('.erro-validacao');

    if (qtderros === null) {
      let template = document.querySelector('.erro-validacao').cloneNode(true);

      template.textContent = msg;

      let inputParent = input.parentNode;

      template.classList.remove('template');

      inputParent.appendChild(template);
    }

  }

  // limpa as validações da tela
  cleanValidations(validations) {
    validations.forEach(el => el.remove());
  }
}

let form = document.getElementById('registro');
let submit = document.getElementById('botao');
let nome = document.getElementById('nome');
let userCad = document.getElementById('userCad');
let senhaCad = document.getElementById('senhaCad');


let validator = new Validator();

// evento de envio do form, que valida os inputs e salva no localStorage
form.addEventListener('submit', function(e) {
  e.preventDefault();
  
  // resgata todas as mensagens de erro existentes
  let mensagensErro = form.querySelectorAll('.erro-validacao');

  // executa a validação
  validator.validate(form);

  // verifica se há mensagens de erro após a validação
  let novasMensagensErro = form.querySelectorAll('.erro-validacao');
  
  if (novasMensagensErro.length === 0) {
    // Salvar no localStorage
    let listaUser = JSON.parse(localStorage.getItem('listaUser') || '[]');
    
    // Verifica se o CPF já existe
    let cpfExists = listaUser.some(user => user.cpf === cpf.value);

    // Verifica se o usuário já existe
    let userCadExists = listaUser.some(user => user.userCad === userCad.value);

    if (cpfExists || userCadExists) {
      if (cpfExists) {
        let mensagensErro = 'CPF já cadastrado.';
        validator.printMensagem(cpf, mensagensErro);
      }
      if (userCadExists) {
        let mensagensErro = 'Este usuário já está cadastrado.';
        validator.printMensagem(userCad, mensagensErro);
      }
    } else {
      // Adiciona o usuário à lista
      listaUser.push({
        cpf: cpf.value,
        userCad: userCad.value,
      });

      // Salva no Local Storage
      localStorage.setItem('listaUser', JSON.stringify(listaUser));
      
      // Submeter o formulário
      form.submit();
    }
  } else {
    // Limpa as mensagens de erro antigas
    if (mensagensErro.length > 0) {
      validator.cleanValidations(mensagensErro);
    }
  }
});
//----------------  VALIDAÇÃO  ----------------// 

//----------------  VALIDAÇÃO CPF  ----------------// 
function CadastrarCPF() {
  const input = document.getElementById("cpf");

  //evento que permite somente números
  input.addEventListener("keypress", somenteNumeros);

  function somenteNumeros(e) {
    var charCode = (e.which) ? e.which : e.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      e.preventDefault();
    }

    let inputLength = input.value.length

    // adiciona as pontuações do cpf 
    if (inputLength === 3 || inputLength === 7) {
      input.value += '.'

    } else if (inputLength === 11) {
      input.value += '-'
    }
  }

  // impede a ação de colar no campo CPF
  input.addEventListener("paste", SemColar);

  function SemColar(e) {
    e.preventDefault();
  }
}

function validarCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres especiais
  if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) {
      return false;
  }

  let soma = 0;
  for (let i = 0; i < 9; i++) {
      soma += parseInt(cpf.charAt(i)) * (10 - i);
  }

  let resto = soma % 11;
  let digitoVerificador1 = resto < 2 ? 0 : 11 - resto;

  soma = 0;
  for (let i = 0; i < 10; i++) {
      soma += parseInt(cpf.charAt(i)) * (11 - i);
  }

  resto = soma % 11;
  let digitoVerificador2 = resto < 2 ? 0 : 11 - resto;

  return parseInt(cpf.charAt(9)) === digitoVerificador1 && parseInt(cpf.charAt(10)) === digitoVerificador2;
}

document.getElementById('cpf').addEventListener('blur', function() {
  let cpf = this.value;
  if (!validarCPF(cpf)) {
      this.value = '';
  }
});


//----------------  VALIDAÇÃO CPF  ----------------// 

//----------------  FORMATAÇÃO CELULAR E TELEFONE  ----------------// 
//CELULAR
function CadastrarCelular() {
  const input = document.getElementById("celular");
  input.value += "+55 (";

  //evento que permite somente números
  input.addEventListener("keypress", somenteNumeros);

  function somenteNumeros(e) {
    var charCode = (e.which) ? e.which : e.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      e.preventDefault();
    }

    let inputLength = input.value.length

    // adiciona os caracteres 
    if (inputLength === 7) {
      input.value += ') '
    } else if (inputLength === 14) {
      input.value += '-'
    }
  }

  // impede a ação de colar
  input.addEventListener("paste", SemColar);

  function SemColar(e) {
    e.preventDefault();
  }
}

function VerificarCelular() {
  let celular = document.getElementById("celular").value.toString();
  if (celular.charAt(9) != 9 || celular.length != 19) {

    document.getElementById("celular").value = "";
  }
}
//CELULAR

// TELEFONE
function CadastrarTelefone() {
  const input = document.getElementById("telefone");
  input.value += "+55 (";

  //evento que permite somente números
  input.addEventListener("keypress", somenteNumeros);

  function somenteNumeros(e) {
    var charCode = (e.which) ? e.which : e.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      e.preventDefault();
    }

    let inputLength = input.value.length

     // adiciona os caracteres 
    if (inputLength === 7) {
      input.value += ') '
    } else if (inputLength === 13) {
      input.value += '-'
    }
  }

  // impede a ação de colar
  input.addEventListener("paste", SemColar);

  function SemColar(e) {
    e.preventDefault();
  }
}

function VerificarTelefone() {
  let telefone = document.getElementById("telefone").value.toString();
  if (telefone.charAt(9) < 2 || telefone.charAt(9) > 5 || telefone.length != 18) {

    document.getElementById("telefone").value = "";
  }
}
// TELEFONE
//----------------  FORMATAÇÃO CELULAR E TELEFONE  ----------------//  

//---------------  OCULTAR SENHA  ----------------//

let btn = document.querySelector('#verSenha');
let btnConfirm = document.querySelector('#verConfirmSenha');

btn.addEventListener('click', ()=>{
  let inputSenha = document.querySelector('#senhaCad');

  if(inputSenha.getAttribute('type') == 'password'){
    inputSenha.setAttribute('type', 'text');
  } else {
    inputSenha.setAttribute('type', 'password');
  }
});

btnConfirm.addEventListener('click', ()=>{
  let inputConfirmSenha = document.querySelector('#confirmSenha');

  if(inputConfirmSenha.getAttribute('type') == 'password'){
    inputConfirmSenha.setAttribute('type', 'text');
  } else {
    inputConfirmSenha.setAttribute('type', 'password');
  }
});
//---------------  OCULTAR SENHA  ----------------//

senhaCad.addEventListener('keypress', function(e) {
  if (this.value.length >= 8) {
    e.preventDefault();
  }
});

confirmSenha.addEventListener('keypress', function(e) {
  if (this.value.length >= 8) {
    e.preventDefault();
  }
});

userCad.addEventListener('keypress', function(e){
  if (this.value.length >= 6 ){
    e.preventDefault();
  }
});

celular.addEventListener('keypress', function(e) {
  if (this.value.length >= 19) {
    e.preventDefault();
  }
});

telefone.addEventListener('keypress', function(e) {
  if (this.value.length >= 18) {
    e.preventDefault();
  }
});

cpf.addEventListener('keypress', function(e) {
  if (this.value.length >= 14) {
    e.preventDefault();
  }
});

//--------------- VERIFICAR SE JÁ EXISTE ----------------//

userCad.addEventListener('blur', function() {
  let userCadValue = userCad.value;
  let listaUser = JSON.parse(localStorage.getItem('listaUser') || '[]');

  for (let i = 0; i < listaUser.length; i++) {
    if (listaUser[i].userCad === userCadValue) {
      let mensagensErro = `Este usuário já está cadastrado.`;
      validator.printMensagem(userCad, mensagensErro);
      break;
    } 
  }
});

userCad.addEventListener('focus', function() {
  let mensagensErro = this.parentNode.querySelector('.erro-validacao');
  if (mensagensErro) {
    mensagensErro.remove();
  }
});


cpf.addEventListener('blur', function() {
  let listaUser = JSON.parse(localStorage.getItem('listaUser') || '[]');
  let cpfExists = listaUser.some(user => user.cpf === cpf.value);

  if (cpfExists) {
    let mensagensErro = 'CPF já cadastrado.';
    validator.printMensagem(cpf, mensagensErro);
  }
});

cpf.addEventListener('focus', function() {
  let mensagensErro = this.parentNode.querySelector('.erro-validacao');
  if (mensagensErro) {
    mensagensErro.remove();
  }
});


//--------------- VERIFICAR SE JÁ EXISTE ----------------//