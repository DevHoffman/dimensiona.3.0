<?php
require_once 'assets/includes/header.php';

?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h1 align="center">Import Excel</h1>
                <br />

                <form action="envia.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="arquivo" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?php
require_once 'assets/includes/footer.php';

?>