function checkPassword(input)
{
   if (input.value != document.getElementById('password').value)
      input.setCustomValidity("La password non corrisponde.");
  else
      input.setCustomValidity('');
}
