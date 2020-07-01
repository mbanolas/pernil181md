<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function do_upload()
    {
        //subir Boka
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);


        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors(), 'data' => array('orig_name' => $this->upload->data()['file_name']));
            $dato = array();
            $this->load->view('templates/header', $dato);      // encabezamiento MD
            $this->load->view('templates/menus');              // menú
            $this->load->view('upload/upload_form');           // upload form
            $this->load->view('templates/footer');              // pie MD
        } else {
            $datosArchivo = $this->upload_->getDatos($this->upload->data());

            if (!array_key_exists('exito', $datosArchivo)) {

                $dato['productoNoExistente'] = $datosArchivo['productoNoExistente'];
                $dato['resultado'] = array_key_exists('exito', $datosArchivo) ? "No se ha subido los datos de Boka porque ya existen " : "";
                $dato['upload_data'] = array_key_exists('datosArchivo', $datosArchivo) ? $datosArchivo['datosArchivo'] : "";
                $dato['tickets'] = 0;
                $dato['exito'] = array_key_exists('exito', $datosArchivo) ? $datosArchivo['exito'] : "";
                $dato['codigosSubidos'] = 0;
                $dato['base'] = array();
                $dato['autor'] = 'Miguel Angel Bañolas';
                $data = array();
                $this->load->view('templates/header.html', $dato);
                $this->load->view('templates/top.php', $dato);
                //$this->load->view('upload_error', $dato);
                $this->load->view('upload_success', $dato);

                $this->load->view('templates/footer.html', $dato);
                $this->load->view('myModal');
                return;
            }

            if ($datosArchivo['productoNoExistente']) {
                $dato['productoNoExistente'] = $datosArchivo['productoNoExistente'];
                $dato['resultado'] = "No se ha subido los datos. Error base datos productos";
            } else {
                $dato['upload_data'] = $datosArchivo['datosArchivo'];
                $dato['resultado'] = $datosArchivo['resultado'];
                $dato['linea'] = array_key_exists('linea', $datosArchivo) ? $datosArchivo['linea'] : "";
                $dato['tickets'] = array_key_exists('tickets', $datosArchivo) ? $datosArchivo['tickets'] : "";
                $dato['codigosSubidos'] = array_key_exists('codigosSubidos', $datosArchivo) ? $datosArchivo['codigosSubidos'] : "";
                $dato['base'] = array_key_exists('base', $datosArchivo) ? $datosArchivo['base'] : array();
                $dato['exito'] = $datosArchivo['exito'];
                $dato['iva'] = array_key_exists('iva', $datosArchivo) ? $datosArchivo['iva'] : "";
                $dato['total'] = array_key_exists('total', $datosArchivo) ? $datosArchivo['total'] : "";
                $dato['productoNoExistente'] = $datosArchivo['productoNoExistente'];
                $dato['fecha'] = array_key_exists('fecha', $datosArchivo) ? $datosArchivo['fecha'] : "";
                $dato['resultadoPreciosTarifas'] = array_key_exists('resultadoPreciosTarifas', $datosArchivo) ? $datosArchivo['resultadoPreciosTarifas'] : "";
                $dato['resultadosStocksTotales'] = array_key_exists('resultadosStocksTotales', $datosArchivo) ? $datosArchivo['resultadosStocksTotales'] : "";

                $resumen = '<br />' . 'TOTAL ' . $dato['tickets'] . ' Tickets' . '<br />' . $dato['codigosSubidos'] . '<br>';

                //para no reportar las ventas
                $ventas = '';

                //registra ventas   
                if (isset($datosArchivo['ultimoIDAnterior']) && isset($datosArchivo['ultimoIDActual']))
                    $this->registroVentas($datosArchivo['ultimoIDAnterior'], $datosArchivo['ultimoIDActual']);

                $reportPesoVariasUnidades = "";
                if (array_key_exists('reportPesoVariasUnidades', $datosArchivo)) {
                    if ($datosArchivo['reportPesoVariasUnidades'] != "") {
                        $reportPesoVariasUnidades = '<br><h3 style="color:red;">' . 'Posibles productos vendidos a peso con varias unidades </h3>' . $datosArchivo['reportPesoVariasUnidades'];
                    }
                }

                if (array_key_exists('fecha', $datosArchivo)) {
                    $mensaje = $resumen . '<br>'
                        . '<h3>Comparación precios con diferencias Base Datos productos y Boka' . ' (' . $datosArchivo['fecha'] . ')</h3>'
                        . $datosArchivo['resultadoPreciosTarifas'] . '<br>';
                    $mensaje .= '<br>Fin del informe.';
                    $from = host() . ' - Boka';
                    $subject = 'Informe Boka subido. Precios Boka vs BD productos.';
                    enviarEmail($this->email, $subject, $from, $mensaje, 1);
                }


                if (array_key_exists('fecha', $datosArchivo)) {
                    $mensaje = $resumen . '<br>'
                        . '<h3>Productos con stocks iguales o inferiores al mínimo stock ' . ' (' . $datosArchivo['fecha'] . ')</h3>'
                        . $datosArchivo['resultadosStocksTotales'] . $reportPesoVariasUnidades;
                    $mensaje .= '<br>Fin del informe.';
                    $from = host() . ' - Boka';
                    $subject = 'Informe Boka subido. Stocks.';
                    enviarEmail($this->email, $subject, $from, $mensaje, 5);
                }
                /*
                if (array_key_exists('fecha', $datosArchivo)) {
                    $ventas = '';
                    $asignaciones='<h3>Ningún producto vendido a peso</h3>';
                    if($this->db->query("SELECT * FROM pe_asignacion_productos")->num_rows()>0){
                        $result=$this->db->query("SELECT a.id_producto as id_producto,"
                                . " a.num_productos as num_productos,"
                                . " a.peso_vendido as peso_vendido,"
                                . " a.peso_asignado as peso_asignado,"
                                . " p.codigo_producto as codigo_producto,"
                                . " a.rangos as rangos,"
                                . " p.nombre as nombre FROM pe_asignacion_productos a"
                                . " LEFT JOIN pe_productos p ON p.id=a.id_asignado")->result();
                        $asignaciones='<table >';
                        $asignaciones.="<tr >";
                            $asignaciones.="<th style='border-bottom:1px solid black'>"."Código Boka"."</th>";
                            $asignaciones.="<th style='border-bottom:1px solid black'>"."Peso vendido (g)"."</th>";
                            
                            $asignaciones.="<th style='border-bottom:1px solid black'>Rangos</th>";
                            $asignaciones.="<th style='border-bottom:1px solid black'>"."Peso asignado"."</th>";
                            $asignaciones.="<th style='border-bottom:1px solid black'>"."Código asignado"."</th>";
                            $asignaciones.="<th style='border-bottom:1px solid black'>"."Nombre Producto"."</th>";
                            
                            $asignaciones.="</tr>";
                        
                        foreach($result as $k=>$v){
                            $asignaciones.="<tr>";
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->id_producto."</td>";
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->peso_vendido."</td>";
                            
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->rangos."</td>";
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->peso_asignado."</td>";
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->codigo_producto."</td>";
                            $asignaciones.="<td style='border-bottom:1px solid black'>".$v->nombre."</td>";
                            
                            $asignaciones.="</tr>";
                        }
                        $asignaciones.="</table>";
                    }
                    
                    $message=$resumen . '<br>'
                       . $ventas . '<h3>Asignación codigos productos vendidos a peso' . ' (' . $datosArchivo['fecha'] . ')</h3>'
                    . $asignaciones;
                    $from=host().' - Boka';
                    $subject='Asignación códigos ventas a peso.';
                    $asignaciones='<h3>Productos vendidos a peso: asignación a códigos unitarios</h3><br>'.$asignaciones.'<br>Fin del informe.';
                    enviarEmail($this->email, $subject,$from,$asignaciones,1);
                
                }
                */
            }

            $dato['autor'] = 'Miguel Angel Bañolas';
            $data = array();
            $this->load->view('templates/header.html', $dato);
            $this->load->view('templates/top.php', $dato);
            $this->load->view('upload_success', $dato);
            $this->load->view('templates/footer.html', $dato);
            $this->load->view('myModal');
        }
    }

}