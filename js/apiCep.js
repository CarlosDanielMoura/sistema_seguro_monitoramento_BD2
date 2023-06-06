$(document).ready(function () {
  let divEl = document.querySelector("#cep_end");

  divEl.addEventListener("click", function () {
    let valueCep = document.querySelector("#vlr_cep_end").value;
    var numero = valueCep;
    var numeroSemHifen = numero.replace(/-/g, "");
    getCep(numeroSemHifen);
  });

  const getCep = async (cep) => {
    const url = `https://viacep.com.br/ws/${cep}/json/`; // Replace with the actual API endpoint
    try {
      const response = await fetch(url);
      const data = await response.json();
      // Handle the API response data
      $("#rua_end").val(data.logradouro);
      $("#bairro_end").val(data.bairro);
      $("#cidade_end").val(data.localidade);
      $("#uf_end").val(data.uf);
    } catch (error) {
      // Handle any errors that occur during the request

      console.log(error);
    }
  };

  const cepInput = document.querySelector("#vlr_cep_end");

  cepInput.addEventListener("input", function () {
    let cep = this.value.replace(/\D/g, "");

    if (cep.length > 5) {
      cep = cep.replace(/^(\d{5})(\d)/, "$1-$2");
    }

    this.value = cep;
  });
});
