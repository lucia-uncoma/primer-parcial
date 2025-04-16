<?php
include_once "Vuelos.php"; // Asumo que todo tu código anterior está ahí

// Crear responsables (Personas)
$responsable1 = new Persona("Laura", "Robertazzi", "Calle false 123", "test@gmail.com", "123456789");
$responsable2 = new Persona("Carlos", "Martínez", "Calle Falsa 456", "blabla@gmail.com", "987654321");

// Crear vuelos
$vuelo1 = new Vuelo(1001, 15000, "2025-05-01", "Madrid", "10:00", "07:00", 200, 200, $responsable1);
$vuelo2 = new Vuelo(1002, 18000, "2025-05-01", "Barcelona", "15:00", "12:00", 150, 150, $responsable1);
$vuelo3 = new Vuelo(2001, 20000, "2025-05-02", "París", "11:00", "08:00", 100, 100, $responsable2);
$vuelo4 = new Vuelo(2002, 22000, "2025-05-02", "Londres", "18:00", "15:00", 180, 180, $responsable2);

// Crear aerolíneas con sus vuelos
$aerolinea1 = new Aerolinea(1, "LAN", [$vuelo1, $vuelo2]);
$aerolinea2 = new Aerolinea(2, "JetSmart", [$vuelo3, $vuelo4]);

// Crear aeropuerto con sus aerolineas
$aeropuerto1 = new Aeropuerto("1600a", "Av Falsa 1234", [$aerolinea1, $aerolinea2]);

$venta = $aeropuerto1->ventaAutomatica(3, "2025-05-01", "Madrid");

if ($venta !== null) {
    echo "Venta realizada correctamente: \n";
    echo $venta; 
} else {
    echo "No se pudo realizar la venta.";
}


if ($vuelo1->asignarAsientosDisponibles($cantPasajeros)) {
    echo "✅ Se asignaron $cantPasajeros asientos correctamente.\n";
    echo "Asientos disponibles ahora: " . $vuelo1->getCantAsientosDisponibles() . "\n";
} else {
    echo "❌ No hay suficientes asientos disponibles.\n";
}
?>