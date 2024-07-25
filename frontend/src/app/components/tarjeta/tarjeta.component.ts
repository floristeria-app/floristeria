import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Pedido } from '../../model/pedido';
import { PedidoService } from '../../services/pedido.service';
import { ImagenTarjetaService } from '../../services/imagenTarjeta.service';
import { Motivo } from '../../model/motivo';
import { DedicatoriaService } from '../../services/dedicatoria.service';
import { GLOBAL } from '../../services/GLOBAL';

@Component({
  selector: 'app-tarjeta',
  templateUrl: './tarjeta.component.html',
  styleUrls: ['./tarjeta.component.css'] ,
  providers: [PedidoService, ImagenTarjetaService, DedicatoriaService]
})
export class TarjetaComponent implements OnInit {

	public idpedido;
	public motivo;
 	public fecharecibo = new Date().toDateString();
 	public recibi;
 	public status;
 	public pedido;
 	public errorMessage;
 	public date : Date = new Date();
 	public idcliente = null;
 	public pedido2 = null;
 	public imagenes;
 	public dedicatorias;
 	public status_get_pedido;
 	public mensaje:string = "";
  public url;
  public url2;

  	constructor(private _PedidoService : PedidoService,
  		private _imagenTarjetaService : ImagenTarjetaService,
  		private _dedicatoriaService : DedicatoriaService,
        private _route: ActivatedRoute,
        private _router: Router) {
          this.url = GLOBAL.url;
        }

  	ngOnInit() {
  		this.pedido2 = new Pedido(1,"","","",false,1,1,this.date, this.date,this.date,"","","","",this.idcliente,false,this.date,"");
  		this.getPedido();
  		console.log(this.pedido);
  		this.listarImagenes();
  		this.listarDedicatorias();
  	}

  	getPedido(){
    this._route.params.subscribe(
        params =>{

        let id = + params["id"];

        this._PedidoService.Pedido(id).subscribe(
          response => {
            this.pedido2 = response['data'];
            this.motivo = this.pedido2.motivomotivo;
            console.log(this.pedido2);
            console.log(this.motivo);
            this.status_get_pedido = response['status'];

            if (this.status_get_pedido != 'success') {
              this._router.navigate(["/home"]);
            }
          },
          error => {
            this.errorMessage = <any>error;
          if (this.errorMessage != null) {
            console.log(this.errorMessage);
            alert("Error en la peticion");
          }
          }
        );
      }
      );
    }

  	imprimir(){
  		window.print();
  	}

  	listarImagenes(){
  		this._route.params.subscribe(
        params =>{

  		let id = + params["motivo"];

  		this._route.params.subscribe(params=>{
       		this._imagenTarjetaService.listarImagenesPorMotivo(id).subscribe(
          		response =>{
            		this.status = response['status'];
            		if (this.status != "success") {
              			this.status = "error";
            		}else{
              			this.imagenes = response['data'];
               			console.log(this.imagenes);
           	 		}
          		},
          		error =>{
            		this.errorMessage = <any>error;
            		if (this.errorMessage != null) {
              			console.log(this.errorMessage);
              			alert("Error en la peticion");
            		}
          		}
        		);
    	});
  		}
  		);
  	}

  	listarDedicatorias(){
  		this._route.params.subscribe(
        params =>{

  		let id = + params["motivo"];

  		this._route.params.subscribe(params=>{
       		this._dedicatoriaService.listarDedicatoriaPorMotivo(id).subscribe(
          		response =>{
            		this.status = response['status'];
            		if (this.status != "success") {
              			this.status = "error";
            		}else{
              			this.dedicatorias = response['data'];
               			console.log(this.dedicatorias);
           	 		}
          		},
          		error =>{
            		this.errorMessage = <any>error;
            		if (this.errorMessage != null) {
              			console.log(this.errorMessage);
              			alert("Error en la peticion");
            		}
          		}
        		);
    	});
  		}
  		);
  	}

  	cambiarFondo(url){
  		this.url2 = this.url + "/uploads/tarjeta/" + url;
  		console.log(this.url2);
  	}

  	cambiarMensaje(dedicatoria){
  		this.mensaje = dedicatoria;
  	}

}
