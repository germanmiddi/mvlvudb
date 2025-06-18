/**
 * Formatea números agregando puntos como separador de miles
 * @param {number|string} number - El número a formatear
 * @returns {string} - El número formateado con puntos como separador de miles
 */
export function formatNumberWithDots(number) {
    // Convertir a string si es un número
    const numStr = number.toString();

    // Si no es un número válido, retornar el valor original
    if (isNaN(number) || number === '' || number === null || number === undefined) {
        return numStr;
    }

    // Separar parte entera y decimal si existe
    const parts = numStr.split('.');
    const integerPart = parts[0];
    const decimalPart = parts[1];

    // Formatear la parte entera agregando puntos cada 3 dígitos desde la derecha
    const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Retornar con decimales si existen, sin decimales si no existen
    return decimalPart ? `${formattedInteger},${decimalPart}` : formattedInteger;
}

export default formatNumberWithDots;
