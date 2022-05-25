document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
    darkMode();

})

function eventListeners(){
    const mobileMenu= document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar');
}

function darkMode(){

    //leer la preferencia del usuario en el navegador
    const prefiereDarkmode = window.matchMedia('(prefers-color-scheme: dark)');

    if ( prefiereDarkmode.matches ){
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }
    
    //Asignar un método de escucha para cambiar el darkmode 
    //de forma automática al momento de cambiar el tema del SISTEMA (NO DEL NAVEGADOR)
    
    prefiereDarkmode.addEventListener('change', function(){

        if ( prefiereDarkmode.matches ){
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    })


    //------------Programar el click de DarkMode -----------------------------

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    
    botonDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    })
}

function mostrarMetodosContacto(e){

    const contactoDiv = document.querySelector('#contacto');
    if(e.target.value === 'telefono'){
        contactoDiv.innerHTML=`
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y la hora para ser contactado</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]" required>
            
            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="20:00" name="contacto[hora]" required>
        `;
    }else{
        contactoDiv.innerHTML=`
            <label for="email">E-mail</label>
            <input type="email" id="email" name="contacto[email]" required>
        `;
    }
}

