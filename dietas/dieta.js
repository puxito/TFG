function crearCajetillas(numComidas) {
    const comidasDiv = document.getElementById('comidas');
    comidasDiv.innerHTML = ''; 

    for (let i = 1; i <= numComidas; i++) {
        const comidaContainer = document.createElement('div');
        comidaContainer.classList.add('comida-container');
        comidaContainer.innerHTML = `
            <div>
                <h3>Comida ${i}</h3>
                <button onclick="seleccionarProductosDesdeCSV(${i})">Añadir productos</button>
                <select id="productosComida${i}"></select>
            </div>
        `;
        comidasDiv.appendChild(comidaContainer);
    }
}
// Event listener para el cambio en el número de comidas
document.getElementById('numComidas').addEventListener('change', function() {
    const numComidas = parseInt(this.value);
    crearCajetillas(numComidas);
});