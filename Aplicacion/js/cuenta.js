// Depositar saldo
$(".depositar").submit(function(event) {
    event.preventDefault();
    const idCuenta = $(this).data("id");
    const monto = $(this).find("input").val();

    $.ajax({
        url: "../controllers/controller_login.php?action=depositar",
        method: "POST",
        data: { id_cuenta: idCuenta, monto: monto },
        success: function(response) {
            if (response.trim() === "deposito_exitoso") {
                alert("¡Depósito realizado con éxito!");
                location.reload();
            } else {
                alert("Error al realizar el depósito.");
            }
        }
    });
});

// Retirar saldo
$(".retirar").submit(function(event) {
    event.preventDefault();
    const idCuenta = $(this).data("id");
    const monto = $(this).find("input").val();

    $.ajax({
        url: "../controllers/controller_login.php?action=retirar",
        method: "POST",
        data: { id_cuenta: idCuenta, monto: monto },
        success: function(response) {
            if (response.trim() === "retiro_exitoso") {
                alert("¡Retiro realizado con éxito!");
                location.reload();
            } else {
                alert("Error al realizar el retiro (saldo insuficiente).");
            }
        }
    });
});
