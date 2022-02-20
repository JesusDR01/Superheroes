<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset-utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Jesús Díaz Rivas</title>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const rows = document.querySelectorAll("tr");
            rows.forEach(row => {
                const modify = row.querySelector(".modify");
                const cancel = row.querySelector(".cancel");
                const actionsForm = row.querySelector("form");
                const spans = row.querySelectorAll("td > span");
                const referenceDivs = row.querySelectorAll("td > div");
                if (modify) {
                    modify.addEventListener("click", function(e) {
                        this.style.display = "none";
                        actionsForm.style.visibility = "visible";
                        spans.forEach(span => {
                            span.style.display = "none";
                        });
                        referenceDivs.forEach(referenceDiv => {
                            referenceDiv.classList.toggle("reference");
                            const referenceInput = referenceDiv.querySelector("input");
                            referenceInput.type = "text";
                            referenceInput.addEventListener("keyup", function() {
                                actionsForm.querySelector(`input[name="${this.name}"]`).value = this.value;
                            });
                        });
                    });
                    cancel.addEventListener("click", function(e){
                        modify.style.display = "block";
                        actionsForm.style.visibility = "hidden";
                        spans.forEach(span => {
                            span.style.display = "block";
                        });
                        referenceDivs.forEach(referenceDiv => {
                            referenceDiv.classList.toggle("reference");
                            const referenceInput = referenceDiv.querySelector("input");
                            referenceInput.type = "hidden";
                        });
                    })
                }
            })
        });
    </script>
    <style>
        table {
            border-spacing: 0 4em;
            border-collapse: separate;
        }

        form {
            visibility: hidden;
            position: absolute;
        }

        tr>td:nth-child(3) {
            position: absolute;
        }

        .reference {
            display: none;
        }
    </style>
</head>

<body class="container">
    <div>
        <?php include("header_view.php") ?>
        <h4>Listado de habilidades</h4>
        <span id="txtHint">
            <?php
            include("list_skills_view.php");
            ?>
    </div>
</body>

</html>