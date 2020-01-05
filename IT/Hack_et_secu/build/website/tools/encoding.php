

<script type="text/javascript">



function pad_with_zeroes(str, length) {
    var my_string = '' + str;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }
    return my_string;
}


function ascii2other(str, base) {
    var arr = [];
    var step = get_steps(base);
    for (i = 0; i < str.length; i ++) {
        var result = Number(str.charCodeAt(i)).toString(base);
        result = pad_with_zeroes(result, step);
        arr.push(result);
    }
    /*if (base==10) {
        return arr.join(' ');
    } else {
        return arr.join('');
    }*/
    return arr.join(' ');
}

function get_steps(base) {
    var step = 0;
    switch (base) {
        case 10:
        case 16:
            step=2;
            break;
        case 2:
            step=8;
            break;
        default:
            step=2;
    }
    return step;
}

function validate_input_steps(arr, step) {
    for (i = 0; i < arr.length; i ++) {
        if (arr[i].length != step) {
            alert("Erreur dans l'input ", arr[i]);
            return false
        }
    }
    return true
}

function contain_spaces(str) {
    for (var i = 0, l = str.length; i < l; i ++) {
        if (str[i]==" ") {
            return true;
        }
    }
    return false;
}

function get_words(str, base) {
    var arr = [];
    var step = get_steps(base);

    if (contain_spaces(str)) {
        arr = str.split(" ")
    } else {
        for (i = 0; i < str.length; i +=step) {
            arr.push(str.substring(i, i+step));
        }
    }
    if (validate_input_steps(arr, step)) {
        return arr;
    } else {
        return false;
    }
}

function dec2ascii(str) {
    var arr = [];
    words = str.split(" ")
    for (i = 0; i < words.length; i++) {
        var ascii = String.fromCharCode(words[i]);
        arr.push(ascii);
    }
    return arr.join('');
}

function hex2ascii(str) {
    var arr = [];
    words = get_words(str, 10);
    for (i = 0; i < words.length; i++) {
        var ascii = String.fromCharCode(parseInt(words[i],16));
        arr.push(ascii);
    }
    return arr.join('');
}

function bin2ascii(str) {
    var arr = [];
    words = get_words(str, 2);

    for (i = 0; i < words.length; i++) {
        arr.push(String.fromCharCode(parseInt(words[i], 2)));
    }
    return arr.join("");
}

//KO
function removing_spaces() {
    document.getElementById("hexadecimal").innerHTML = hexadecimal.value.replace('/\s+/g', '');;
    document.getElementById("binaire").innerHTML = binaire.value.replace('/\s+/g', '');;
}


function conversion(encoding) {
    var ascii = document.getElementById("ascii");
    var decimal = document.getElementById("decimal");
    var hexadecimal = document.getElementById("hexadecimal");
    var binaire = document.getElementById("binaire");
    var res = "";

    switch (encoding) {
        case 'ascii':
            break;
        case 'decimal':
            res = dec2ascii(decimal.value);
            break;
        case 'hexadecimal':
            res = hex2ascii(hexadecimal.value);
            break;
        case 'binaire':
            res = bin2ascii(binaire.value);
            break;
        default:
            break;
    }
    if (res != "") {
        ascii.value = res;
        ascii.innerHTML = res;
    }

    decimal.innerHTML = ascii2other(ascii.value, 10);
    hexadecimal.innerHTML = ascii2other(ascii.value, 16);
    binaire.innerHTML = ascii2other(ascii.value, 2);
}


</script>


<div class="col-md-10" style="margin-top: 4%;">

    <div class="row">
        <div class="col-md-6" >
            <div class="form-group">
                <label for="ascii">ASCII</label>
                <textarea class="form-control" id="ascii" rows="3"></textarea>
                <button type="button" class="btn btn-primary" onclick="conversion('ascii')">Conversion</button>
            </div>

        </div>

        <div class="col-md-6" >
            <div class="form-group">
                <label for="decimal">Decimal</label>
                <textarea class="form-control" id="decimal" rows="3"></textarea>
                <button type="button" class="btn btn-success" onclick="conversion('decimal')">Conversion</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" >
            <div class="form-group">
                <label for="hexadecimal">Hexadecimal</label>
                <textarea class="form-control" id="hexadecimal" rows="3"></textarea>
                <button type="button" class="btn btn-danger" onclick="conversion('hexadecimal')">Conversion</button>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="form-group">
                <label for="binaire">Binaire</label>
                <textarea class="form-control" id="binaire" rows="3"></textarea>
                <button type="button" class="btn btn-warning" onclick="conversion('binaire')">Conversion</button>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top: 50px;">
        <div class="col-md-5" >
        </div>

        <!-- <div class="col-md-3" >
            <div class="form-group">
                <button type="button" class="btn btn-dark" onclick="removing_spaces()">Enlever espaces</button>
            </div>
        </div> -->
    </div>

</div>