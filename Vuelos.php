<?php

class Persona {
    private $nombre;
    private $apellido;
    private $direccion;
    private $mail;
    private $telefono;

    public function __construct($nombre, $apellido, $direccion, $mail, $telefono) {
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDireccion($direccion);
        $this->setMail($mail);
        $this->setTelefono($telefono);
    }
     // Setters
     public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function __toString() {
        return "La persona es:\n" .
               "Nombre completo: " . $this->nombre . " " . $this->apellido . "\n" .
               "Dirección: " . $this->direccion . "\n" .
               "Mail: " . $this->mail . "\n" .
               "Teléfono: " . $this->telefono . "\n";
    }
}

class Vuelo {
    private $numero;
    private $importe;
    private $fecha;
    private $destino;
    private $horaArribo;
    private $horaPartida;
    private $cantAsientosTotales;
    private $cantAsientosDisponibles;
    private $responsable;

    public function __construct($numero, $importe, $fecha, $destino, $horaArribo, $horaPartida, $cantTotales, $cantDisponibles, $responsable) {
        $this->numero = $numero;
        $this->importe = $importe;
        $this->fecha = $fecha;
        $this->destino = $destino;
        $this->horaArribo = $horaArribo;
        $this->horaPartida = $horaPartida;
        $this->cantAsientosTotales = $cantTotales;
        $this->cantAsientosDisponibles = $cantDisponibles;
        $this->responsable = $responsable;
    }

    public function getNumero() { return $this->numero; }
    public function getImporte() { return $this->importe; }
    public function getFecha() { return $this->fecha; }
    public function getDestino() { return $this->destino; }
    public function getHoraArribo() { return $this->horaArribo; }
    public function getHoraPartida() { return $this->horaPartida; }
    public function getCantAsientosTotales() { return $this->cantAsientosTotales; }
    public function getCantAsientosDisponibles() { return $this->cantAsientosDisponibles; }
    public function getResponsable() { return $this->responsable; }

    public function setNumero($numero) { $this->numero = $numero; }
    public function setImporte($importe) { $this->importe = $importe; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function setDestino($destino) { $this->destino = $destino; }
    public function setHoraArribo($horaArribo) { $this->horaArribo = $horaArribo; }
    public function setHoraPartida($horaPartida) { $this->horaPartida = $horaPartida; }
    public function setCantAsientosTotales($cantTotales) { $this->cantAsientosTotales = $cantTotales; }
    public function setCantAsientosDisponibles($cantDisponibles) { $this->cantAsientosDisponibles = $cantDisponibles; }
    public function setResponsable($responsable) { $this->responsable = $responsable; }

    public function asignarAsientosDisponibles($cant_nuevos_pasajeros) {
        $resultado = false;
        if ($cant_nuevos_pasajeros <= $this->cantAsientosDisponibles) {
            $this->cantAsientosDisponibles -= $cant_nuevos_pasajeros;
            $resultado = true;
        }
        return $resultado;
    }

    public function __toString() {
        return "Vuelo Nº: {$this->numero}\n" .
               "Destino: {$this->destino}\n" .
               "Fecha: {$this->fecha}\n" .
               "Hora partida: {$this->horaPartida}\n" .
               "Hora arribo: {$this->horaArribo}\n" .
               "Importe: \${$this->importe}\n" .
               "Asientos disponibles: {$this->cantAsientosDisponibles}/{$this->cantAsientosTotales}\n" .
               "Responsable: {$this->responsable}\n";
    }
}

class Aerolinea {
    private $id;
    private $nombre;
    private $vuelosProgramados;

    public function __construct($id, $nombre, $vuelosProgramados = []) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->vuelosProgramados = $vuelosProgramados;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getVuelosProgramados() { return $this->vuelosProgramados; }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setVuelosProgramados($vuelos) {
        if (is_array($vuelos)) {
            $this->vuelosProgramados = $vuelos;
        }
    }

    public function agregarVuelo($vuelo) {
        $this->vuelosProgramados[] = $vuelo;
    }

    public function incorporarVuelo($nuevoVuelo) {
        $vuelos = $this->getVuelosProgramados();
        $puedeAgregar = true;

        foreach ($vuelos as $vuelo) {
            $mismoDestino = $vuelo->getDestino() === $nuevoVuelo->getDestino();
            $mismaFecha = $vuelo->getFecha() === $nuevoVuelo->getFecha();
            $mismaHoraPartida = $vuelo->getHoraPartida() === $nuevoVuelo->getHoraPartida();

            if ($mismoDestino && $mismaFecha && $mismaHoraPartida) {
                $puedeAgregar = false;
            }
        }

        if ($puedeAgregar) {
            setVuelosProgramados($vuelos[] = $nuevoVuelo);
        }

        return $puedeAgregar;
    }

    public function darVueloADestino($destino, $cant_asientos, $fecha) {
        $vuelosDisponibles = null;
        $vuelosProgramados = $this->getVuelosProgramados();

        foreach ($vuelosProgramados as $vuelo) {
            $mismoDestino = $vuelo->getDestino() === $destino;
            $mismosAsientosDisponibles = $vuelo->getCantAsientosDisponibles() >= $cant_asientos;
            $fechaVuelo = $vuelo->getFecha() == $fecha;

            if ($mismoDestino && $mismosAsientosDisponibles && $fechaVuelo) {
                if ($vuelo->asignarAsientosDisponibles($cant_asientos)) {
                    $vuelosDisponibles = $vuelo;
                }
            }
        }

        return $vuelosDisponibles;
    }

    public function montoPromedioRecaudado(){
        $colVuelosAerolinea = $this->vuelosProgramados;
        $promedio = 0;
        $imp_vuelo_recaudado = 0;
        $cant_vuelos = count($colVuelosAerolinea);

        if ($cant_vuelos > 0) {
            foreach ($colVuelosAerolinea as $unObjVuelo) {
                $v_importe = $unObjVuelo->getImporte();
                $v_asientos_vendidos = $unObjVuelo->getCantAsientosTotales() - $unObjVuelo->getCantAsientosDisponibles();
                $imp_vuelo_recaudado += $v_importe * $v_asientos_vendidos;
            }
            $promedio = $imp_vuelo_recaudado / $cant_vuelos;
        }
        return $promedio;
    }

    public function __toString() {
        $cadena = "Identificación: {$this->id}\n";
        $cadena .= "Nombre: {$this->nombre}\n";
        $cadena .= "Vuelos programados:\n";

        foreach ($this->vuelosProgramados as $vuelo) {
            $cadena .= $vuelo . "\n";
        }

        return $cadena;
    }
}

class Aeropuerto {
    private $denominacion;
    private $direccion;
    private $coleccionAerolineas;

    public function __construct($denominacion, $direccion, $coleccionAerolineas = []) {
        $this->denominacion = $denominacion;
        $this->direccion = $direccion;
        $this->coleccionAerolineas = $coleccionAerolineas;
    }

    public function getDenominacion() { return $this->denominacion; }
    public function getDireccion() { return $this->direccion; }
    public function getColeccionAerolineas() { return $this->coleccionAerolineas; }

    public function setDenominacion($denominacion) { $this->denominacion = $denominacion; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setColeccionAerolineas($coleccionAerolineas) {
        if (is_array($coleccionAerolineas)) {
            $this->coleccionAerolineas = $coleccionAerolineas;
        }
    }

    public function agregarAerolinea($aerolinea) {
        $resultado = false;
        if ($aerolinea instanceof Aerolinea) {
            $existe = false;
            foreach ($this->coleccionAerolineas as $existente) {
                if ($existente->getId() === $aerolinea->getId()) {
                    $existe = true;
                }
            }
            if (!$existe) {
                $this->coleccionAerolineas[] = $aerolinea;
                $resultado = true;
            }
        }
        return $resultado;
    }

    public function retornarVuelosAerolinea($aerolinea) {
        $aerolineas = $this->getColeccionAerolineas();
        $colVuelosAerolinea = [];

        foreach ($aerolineas as $unObjAerolinea) {
            if ($unObjAerolinea->getNombre() === $aerolinea) {
                $colVuelosAerolinea = $unObjAerolinea->getVuelosProgramados();
            }
        }

        return $colVuelosAerolinea;
    }

    public function ventaAutomatica($cant_asientos, $fecha, $destino) {
        $ventaRealizada = null;
        $aerolineas = $this->getColeccionAerolineas();

        foreach ($aerolineas as $unObjAerolinea) {
            if ($ventaRealizada === null) {
                $ventaRealizada = $unObjAerolinea->darVueloADestino($destino, $cant_asientos, $fecha);
            }
        }

        return $ventaRealizada;
    }

    public function promedioRecuadoXAerolinea($identificacionAerolinea) {
        $promedioAerolinea = 0;
        foreach ($this->coleccionAerolineas as $aerolinea) {
            if ($aerolinea->getId() === $identificacionAerolinea) {
                $promedioAerolinea = $aerolinea->montoPromedioRecaudado();
            }
        }
        return $promedioAerolinea;
    }

    public function __toString() {
        $cadena = "Aeropuerto: {$this->denominacion}\n";
        $cadena .= "Dirección: {$this->direccion}\n";
        $cadena .= "Aerolíneas:\n";

        if (!empty($this->coleccionAerolineas)) {
            foreach ($this->coleccionAerolineas as $aerolinea) {
                $cadena .= $aerolinea . "\n";
            }
        } else {
            $cadena .= "No hay aerolíneas registradas.\n";
        }

        return $cadena;
    }
}

?>
