    <title>Formulaire HTML5</title>
    <style>
        :invalid { 
          background-color: #F0DDDD;
          border-color: #e88;
          -webkit-box-shadow: 0 0 5px rgba(255, 0, 0, .8);
          -moz-box-shadow: 0 0 5px rbba(255, 0, 0, .8);
          -o-box-shadow: 0 0 5px rbba(255, 0, 0, .8);
          -ms-box-shadow: 0 0 5px rbba(255, 0, 0, .8);
          box-shadow:0 0 5px rgba(255, 0, 0, .8);
        }
 
        :required {
          border-color: #88a;
          -webkit-box-shadow: 0 0 5px rgba(0, 0, 255, .5);
          -moz-box-shadow: 0 0 5px rgba(0, 0, 255, .5);
          -o-box-shadow: 0 0 5px rgba(0, 0, 255, .5);
          -ms-box-shadow: 0 0 5px rgba(0, 0, 255, .5);
          box-shadow: 0 0 5px rgba(0, 0, 255, .5);
        }
 
        #reservation form {
          width:300px;
          margin: 20px auto;
        }
 
        #reservation input {
          font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
          border:1px solid #ccc;
          font-size:20px;
          width:250px;
          min-height:20px;
          display:block;
          margin-bottom:5px;
          margin-top:5px;
          outline: none;
 
          -webkit-border-radius:5px;
          -moz-border-radius:5px;
          -o-border-radius:5px;
          -ms-border-radius:5px;
          border-radius:5px;
        }
 
        #reservation input[type=submit] {
          background:none;
          padding:10px;
          cursor: pointer;
        }
 
        #reservation label{
          cursor: pointer;
        }
    </style>
    <form action="<?php the_permalink(); ?>" method="post">>
 
      <label>Nom complet :</label>
      <input type="text" id="full_name" name="full_name" placeholder="Jane Doe" required>
 
      <label>Adresse e-mail :</label>
      <input type="email" id="email_addr" name="email_addr" required>
 
      <label>Confirmez l'adresse e-mail :</label>
      <input type="email" id="email_addr_repeat" name="email_addr_repeat" required 
       oninput="check(this)">
 
      <input type="submit" value="Effectuer la réservation" /> 
    </form>

    <script>
    function check(input) {
      if (input.value != document.getElementById('email_addr').value) {
        input.setCustomValidity('Les deux adresses e-mail ne correspondent pas.');
      } else {
        // le champ est valide : on réinitialise le message d'erreur
        input.setCustomValidity('');
      }
    }
    </script>
