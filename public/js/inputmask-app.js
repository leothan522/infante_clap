function inputmask(selector, tipo, min = 0, max = 100, simbolos = ' ', utf8 = 'áéíóúÁÉÍÓÚñÑ') {

    //let regex = "[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,!¿? ]{4,}";
    if (tipo === 'alfanumerico'){
        tipo = 'a-zA-Z0-9';
    }

    if (tipo === 'alfa'){
        tipo = 'a-zA-Z';
    }

    if (tipo === 'numerico'){
        tipo = '0-9'
    }

    let regex = "[" + tipo + "" + utf8 + "" + simbolos + "]{"+ min +","+ max +"}";
    $(selector).inputmask({regex: regex });
}

function inputmaskTelefono(selector) {
    $(selector).inputmask("(9999) 999-99.99");
}

//console.log('inputmask');
