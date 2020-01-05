



<div class="col-md-10" style="margin-top: 4%;">
    <div class="row">
        <input type='file' accept='text/plain' onchange='openFile(event)'><br>
    </div>

    <div class="row">
        <div class="col-md-6" >
            <div class="form-group">
                <label for="ascii">ASCII</label>
                <textarea id='ascii_output' class="form-control" id="ascii" rows="40"></textarea>
            </div>

        </div>

        <div class="col-md-6" >
            <div class="form-group">
                <label for="decimal">Decimal</label>
                <textarea id='hex_output' class="form-control" id="decimal" rows="40"></textarea>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    // var openFile = function(event) {
    //     var input = event.target;

    //     var reader = new FileReader();
    //     reader.onload = function() {
    //         var text = reader.result;
    //         var node = document.getElementById('output');
    //         node.innerText = text;
    //         console.log(text);
    //     };
    //     reader.readAsText(input.files[0]);
    // };

    function hex2a(hexx) {
        var hex = hexx.toString();//force conversion
        var str = '';
        for (var i = 0; (i < hex.length && hex.substr(i, 2) !== '00'); i += 2)
            str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
        return str;
    }

    var openFile = function(event) {
        var input = event.target;
        var fr = new FileReader();
        fr.addEventListener('load', function () {
            var u = new Uint8Array(this.result);
            var h = "1 : ";
            var a = "1 : ";
            var count = 1;
            //var //h = new Array(u.length);
            var i = 0;
            while (i < u.length) { // map to hex
                hex_value = (u[i] < 16 ? '0' : '') + u[i].toString(16);
                //a[i] = hex_value;
                if (i!=0 && i%24==0 ) {
                    count += 1;
                    h = h + "\n" + count + " : " + hex_value ;
                    a = a + "\n" + count + " : " + hex2a(hex_value);
                } else {
                    h = h + " " + hex_value;
                    a = a + " " + hex2a(hex_value);
                }
                i += 1;
            }
            u = null; // free memory
            //console.log(h); // work with this

            document.getElementById("ascii_output").innerHTML = a;
            document.getElementById("hex_output").innerHTML = h;
        });
        fr.readAsArrayBuffer(input.files[0]);
    };

    //To move the textareas in same time
    var s1 = document.getElementById('ascii_output');
    var s2 = document.getElementById('hex_output');

    function select_scroll_1(e) { s2.scrollTop = s1.scrollTop; }
    function select_scroll_2(e) { s1.scrollTop = s2.scrollTop; }

    s1.addEventListener('scroll', select_scroll_1, false);
    s2.addEventListener('scroll', select_scroll_2, false);


    /*var openFile = function(event) {
        var input = event.target;
        const reader = new FileReader();
        const f = new Blob(['abc'], {type: 'text/plain'});
        reader.onload = e => {
            console.log(e.target.result);
        };
        reader.readAsArrayBuffer(input.files[0]);
    }*/

</script>