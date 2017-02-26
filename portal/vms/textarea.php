

<textarea id="txtTinyMCE" rows="2" cols="20"></textarea>
<br />
<div id="character_count">
</div>
<br />
<input type="submit" value="Submit" onclick="return ValidateCharacterLength();" />

<script type="text/javascript" src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
    window.onload = function () {
        tinymce.init({
            selector: 'textarea',
            width: 400,
            setup: function (ed) {
                ed.on('keyup', function (e) { 
                    var count = CountCharacters();
                    document.getElementById("character_count").innerHTML = "Characters: " + count;
                });
            }
        });
    }
    function CountCharacters() {
        var body = tinymce.get("txtTinyMCE").getBody();
        var content = tinymce.trim(body.innerText || body.textContent);
        return content.length;
    };
    function ValidateCharacterLength() {
        var max = 20;
        var count = CountCharacters();
        if (count > max) {
            alert("Maximum " + max + " characters allowed.")
            return false;
        }
        return;
    }
</script>

