export default function formatToBRL(value) {
    value = parseFloat(value);

    if(!value){
        value = 0
    }
    
    return `R$ ${value.toFixed(2).replace('.', ',')}`;
}
