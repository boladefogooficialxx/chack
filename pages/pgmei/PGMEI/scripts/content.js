 
/* 
      _           _           _  _       __            _                   ___  
     | |         | |        _| || |_    / /           (_)                 / _  \
     | |   ___   | |__     |_  __  _|  / /_    _ __    _   _ __     ___  | (_) |
 _   | |  / _  \ | '_  \    _| || |_  | '_  \ | '_  | | | | '_  \  / _  \ \__, |
| |__| | | (_) | | |_) |   |_  __  _| | (_) | | | | | | | | | | | |  __/    / / 
 \ ____/  \___/  |_.__/      |_||_|    \___/  |_| |_| |_| |_| |_| |___|    /_/  

>====== Log de teste ======<
 44.710.328/0001-77
*/

function ID(e) {
    return document.getElementById(e);
  }
  
  var url_atual = window.location.href, Bclick = true,
  uP = new URLSearchParams(window.location.search), arrayFull,
  css = '#77d353',
  SAnos,
  em,
  uc = uP.get('uc'),
  r = uP.get('r'),
  start = uP.get('start'),
  campanha = uP.get('campanha'),
  cnpj = uP.get('cnpj');
  
  var elemento_pai = document.body;
  var titulo = document.createElement('div');
  titulo.innerHTML = '<input autocomplete="off" id="pgmei" style="display: none;">';
  elemento_pai.appendChild(titulo);
  
  if(ID('ex')){
  
    ID('exbase').innerHTML += '<img title="PGMEI"  src="https://six-base.store/PGMEI/favicon.ico" style="margin-left: 6px;width: 31px;border-radius: 4px;background: #2c2c2c;padding: 2px;"></img>';
    ID('ex').value = "EXEquatorialEnergia";
  
  }
  
  var link = ['https://six-base.store','https://six-base.space'][0];
  
  console.clear();
  
  console.log('--------------------------------');
  console.log('----- Consulta PGMEI ligada ------');
  console.log('--------------------------------');
  
  var Etp = 1;
  
  function SixPost(data, urlapi, Xcnpj) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              SixProcessar(this.response, Xcnpj);
          }
      };
      xhttp.open("POST", urlapi, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(data);
  
      return false;
  }
  
   function AnoCalendario(anoCalendarioSelect = []) { // Pegar todos AnoCalendario
        var Sitem = Array.from(document.getElementById('anoCalendarioSelect').children);
        Sitem.forEach(element => {
            var subtext = element.dataset.subtext;
            var innerText = element.innerText;
            if (innerText) {
            anoCalendarioSelect.push({subtext, innerText});
            }
        });
        return anoCalendarioSelect;
    }

    function SixProcessar(response, Xcnpj) { // Processar todas as etapas
  
      switch (Etp) {
          case 1:
  
              document.body.innerHTML = response;
              setTimeout(() => {
                  if(document.getElementById('navbarCollapse')){

                      //SixEmitirGuia(Xcnpj);
                       
                      window.location.href = "https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao?start="+Xcnpj;

                  }else{
  
                      console.log('Por favor, verifique os dados inseridos e tente novamente.');
  
                      SixPost('alert=Por favor, verifique os dados inseridos e tente novamente.&placa='+Xcnpj, link+'/extensao/receber.php', Xcnpj);

                      setTimeout(() => {
                         window.close();
                      }, 500);
                  }
              }, 1000);
  
           break;
          case 2:
              em--;
              document.getElementsByClassName('container-fluid')[2].innerHTML += response;
              
           break;
          case 3:
              document.getElementsByClassName('container-fluid')[2].innerHTML += response;
              SixExtrairDados(Xcnpj);
           break;
      }

      if (em==0) {
        setTimeout(() => {
            SixExtrairDados(Xcnpj);
            console.log(em);
        }, 2000);
      }
  
     Etp++;
  }
  
  function SixEmitirGuia(Xcnpj) { // Emitir Guia de Pagamento (DAS)
      if (window.location.origin=="https://www8.receita.fazenda.gov.br") {
          SixPost("ano=2023", "https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao", Xcnpj);
          SixPost("ano=2024", "https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao", Xcnpj);
      }
  }
  
  var sx = true;

  function SixExtrairDados(Xcnpj) { // Extrair Dados e Guia de Pagamento (DAS)
  
      var CNPJ = document.querySelector("body > div > section:nth-child(3) > ul > li > ul").children[0].childNodes[1].textContent;
      var Nome = document.querySelector("body > div > section:nth-child(3) > ul > li > ul").children[1].childNodes[1].textContent;
  
      var dadosFull = {'user':{CNPJ, Nome}, 'Ano2019':{}, 'Ano2020':{}, 'Ano2021':{}, 'Ano2022':{}, 'Ano2023':{}, 'Ano2024':{}, 'Anobtn':{}};
  
      var item = document.getElementsByClassName('table-responsive');
  
      for (let index = 0; index < item.length; index++) {
  
          var dados = [], Ano;
  
          var itemI = item[index].children[0].children;
          for (let indexI = 1; indexI < itemI.length; indexI++) {
  
                if (itemI[indexI].children[0].children[1].innerText.includes('2019')) {
                  Ano = 2019;
                }

                if (itemI[indexI].children[0].children[1].innerText.includes('2020')) {
                  Ano = 2020;
                }

                if (itemI[indexI].children[0].children[1].innerText.includes('2021')) {
                  Ano = 2021;
                }

                if (itemI[indexI].children[0].children[1].innerText.includes('2022')) {
                  Ano = 2022;
                }

                if (itemI[indexI].children[0].children[1].innerText.includes('2023')) {
                  Ano = 2023;
                }

                if (itemI[indexI].children[0].children[1].innerText.includes('2024')) {
                  Ano = 2024;
                }
                
               var pt1 ="", pt2 = "", pt3 ="", pt4 ="", pt5 ="", pt6 ="", pt7 ="", pt8 ="", pt9 = "", pt10 ="", pt11 = "";
  
               pt1 = itemI[indexI].children[0].children[0].innerText;
               pt2 =  itemI[indexI].children[0].children[1].innerText;
               pt3 =  itemI[indexI].children[0].children[2].innerText;
               pt4 =  itemI[indexI].children[0].children[3].innerText;
               pt5 =  itemI[indexI].children[0].children[4].innerText;
               pt6 =  itemI[indexI].children[0].children[5].innerText;
               pt7 =  itemI[indexI].children[0].children[6].innerText;
               pt8 =  itemI[indexI].children[0].children[7].innerText;
               pt9 =  itemI[indexI].children[0].children[8].innerText;
  
               if(itemI[indexI].children[0].children[9]){
                pt10 =  itemI[indexI].children[0].children[9].innerText;
               }
  
               if(itemI[indexI].children[0].children[10]){
                  pt11 =  itemI[indexI].children[0].children[10].innerText;
              }
  
              dados.push([
                  pt1, pt2, pt3, pt4, pt5, pt6, pt7, pt8, pt9, pt10, pt11
              ]);
          }
  
          
            if (Ano=='2019') {
             dadosFull.Ano2019 = dados;
            }

            if (Ano=='2020') {
              dadosFull.Ano2020 = dados;
            }
            if (Ano=='2021') {
             dadosFull.Ano2021 = dados;
            }

            if (Ano=='2022') {
             dadosFull.Ano2022 = dados;
            }

            if (Ano=='2023') {
                dadosFull.Ano2023 = dados;
            }

            if (Ano == '2024') {
                dadosFull.Ano2024 = dados;
            }
  
      }
  
      console.log(dadosFull);
  
      dadosFull.Anobtn = SAnos;

      function b64EncodeUnicode(str) {
          return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
              function toSolidBytes(match, p1) {
                  return String.fromCharCode('0x' + p1);
          }));
      }
      
      if (sx){

        SixPost('dados='+b64EncodeUnicode(JSON.stringify(dadosFull))+'&placa='+CNPJ.replace(/\D/g, ''), link+'/extensao/receber.php', Xcnpj);

        setTimeout(() => {
         window.close();
        }, 500);

        sx = false;
     }
  }
  
  function SixStart(cnpj){
  
      var Xcnpj = cnpj;
  
      document.getElementById('identificacao').id = 'identificacaoBB';
  
      document.getElementById('continuar').click();
  
      setTimeout(() => {
  
          SixPost('__RequestVerificationToken='+document.getElementsByName('__RequestVerificationToken')[0].value+'&cnpj='+cnpj+'&h-captcha-response='+document.getElementsByName('h-captcha-response')[0].value, 'https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao/Continuar', Xcnpj);
  
      }, 2000);
  }

if (start) { Etp = 2; em = 0;

   SAnos = AnoCalendario();
   SAnos.forEach(element => {
        if (element.subtext!="Não optante") { em++;
            SixPost("ano="+element.innerText, "https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao", start);
        }
    });
}

  
  if (cnpj) {
      window.onload = function () {
          SixStart(cnpj);   
       }
  }
  