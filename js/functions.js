//Funzione che controlla che le due password fornite in input corrispondono.
function checkPassword(input)
{
   if (input.value != document.getElementById('password').value)
      input.setCustomValidity("La password non corrisponde.");
  else
      input.setCustomValidity('');
}

function asyncRequest(page,method)
{
  xhttp.open(method, page, true);
  return xhttp.send();
}

//Funzione che disabilita un div html.
function disable(id)
{
  document.getElementById(id).style = "display:none;";
}
//Funzione che disabilita un div html.
function enable(id)
{
  document.getElementById(id).style = "";
  document.getElementById(id).class = "row";
}

//Funzione che abilita e disabilita il campo per inserire l'idirizzo di fatturazione.
function disableEnable(id)
{
  if(document.getElementById('checkbox').checked == true)
  {
    disable(id);
  }
  else
  {
    enable(id);
  }
}

//Funzione che aggiunge automaticamente i trattini all'interno del campo "Numero carta" 
function numeroCarta(id)
{
  var codice = id.value.toString();
  //console.log(codice.length);
  switch(codice.length)
  {
    case 4:
    case 9:
    case 14:
      id.value += "-";
  }
}

//Funzione che simula il ritorno indietro del browser. Utilizzata in errore.php
function tornaIndietro()
{
    window.history.back();
}

//Funzione che controlla che il mese di scandenza della carta sia compreso tra 1 e 12
function checkMonth(element) 
{
  var mese = element.value;
  if(mese <1 || mese >12)
    return false;
  else
    return true;
}

//Funzione che controlla che l'anno di scadenza della carta sia compreso tra l'anno corrente e 10 anni a venire.
function checkYear(element) {
  var anno = element.value;
  var anno_corrente = (new Date()).getFullYear();

  if(anno > anno_corrente + 10)
      return false;
  if(anno < anno_corrente)
      return false;

  return true;
}
