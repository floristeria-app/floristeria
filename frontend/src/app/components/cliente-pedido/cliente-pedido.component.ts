import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Cliente } from '../../model/cliente';
import { Pedido } from '../../model/pedido';
import { ClienteService } from '../../services/cliente.service';
import { PedidoService } from '../../services/pedido.service';
import { MotivoService } from '../../services/motivo.service';

@Component({
  selector: 'app-cliente-pedido',
  templateUrl: './cliente-pedido.component.html',
  styleUrls: ['./cliente-pedido.component.css'],
  providers: [ClienteService,PedidoService, MotivoService]
})
export class ClientePedidoComponent implements OnInit {
	public cliente;
	public pedido;
  public pedido2;
	public pedidos = null;
	public date : Date = new Date();
	public hrcliente;
	public status_get_cliente;
	public errorMessage;
	public idcliente = null;
	public status;
	public pages;
	public pagePrev;
	public pageNext;
  public idpedido;
  public idmotivo;
  public motivos;

  	constructor(private _ClienteService : ClienteService,
  		private _PedidoService : PedidoService,
      private _MotivoService : MotivoService,
        private _route: ActivatedRoute,
        private _router: Router) { }

  	ngOnInit() {
  		this.cliente = new Cliente(1,"","","","","","");
  		this.cliente = this.getCliente();
  		this.pedido = new Pedido(1,"","","",false,1,1,this.date, this.date,this.date,"","","","",this.idcliente,false,this.date,"");
      this.pedido2 = new Pedido(1,"","","",false,1,1,this.date, this.date,this.date,"","","","",this.idcliente,false,this.date,"");
  		this.listarPedidosCliente();
      this.getAllMotivos();
  		console.log(this.idcliente);
  	}

  	listarPedidosCliente(){
  		this._route.params.subscribe(params=>{
      	//this.idcliente = params["id"];

      	if (!this.idcliente) {
      		this.idcliente = null;
      		this._router.navigate(["/cliente"]);
      	}
      	let page = +params["page"];
      	if (!page) {
        	page = 1;
      	}

      	this._PedidoService.getPedidosCliente(page, this.idcliente).subscribe(
          	response =>{
            	this.status = response['status'];
            	if (this.status != "success") {
              		this.status = "error";
            	}else{
              		this.pedidos = response['data'];
               		console.log(this.pedidos);
              		this.pages = [];
              		for (var i = 0; i < response['total_pages']; ++i) {
                		this.pages.push(i);
              		}

              		if (page >= 2) {
                		this.pagePrev = (page - 1);
              		}else{
                		this.pagePrev = page;
              		}

              		if (page <  response['total_pages'] || page == 1) {
                		this.pageNext = (page + 1);
              		}else{
                		this.pageNext = page;
              		}
            	}
          	},
          	error =>{
            	this.errorMessage = <any>error;
            	if (this.errorMessage != null) {
              		console.log(this.errorMessage);
              		alert("Error en la peticion");
            	}
          	});
    	});
  	}

  	creaPedido(value: string){
  		this.hrcliente = value;
  	}

  	getCliente(){
      this._route.params.subscribe(
        params =>{

        this.idcliente = + params["id"];

        this._ClienteService.getCliente(this.idcliente).subscribe(
          response => {
            this.cliente = response['data'];
            console.log(this.cliente);
            this.status_get_cliente = response['status'];

            if (this.status_get_cliente != 'success') {
              this._router.navigate(["/cliente"]);
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


    getPedido(idpedido, value){
      this.hrcliente = value;

      this._route.params.subscribe(
        params =>{

        //let id = + params["id"];

        this._PedidoService.Pedido(idpedido).subscribe(
          response => {
            this.pedido2 = response['data'];
            console.log(this.pedido2);
            this.status_get_cliente = response['status'];

            if (this.status_get_cliente != 'success') {
              this._router.navigate(["/cliente/pedido", this.idcliente]);
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

    newPedido(){
    	let pedido = this.pedido;
        this._PedidoService.create(this.pedido).subscribe(
        response =>{
          this.status = response['status'];
          console.log(pedido);
          if (this.status != 'success') {
            this.status = "error";
          }else{
            this.cliente = response['msg'];
            console.log(this.cliente);
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
      window.location.href = "/cliente/pedido/"+this.idcliente;
      console.log("pedido creado");
    }


    setPagado(id, value){
    this._route.params.subscribe(params =>{
        this._PedidoService.setPagado(id, value).subscribe(
          response =>{
            this.status = response['status'];
            this._router.navigate(["/cliente/pedido", this.idcliente]);
            if (this.status != 'success') {
              this.status = "error";
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
    window.location.href = "/cliente/pedido/"+this.idcliente;
  }

  setEntregado(id, value){
     this._route.params.subscribe(params =>{
        this._PedidoService.setEntregado(id, value).subscribe(
          response =>{
            this.status = response['status'];
            this._router.navigate(["/cliente/pedido", this.idcliente]);
            if (this.status != 'success') {
              this.status = "error";
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
     window.location.href = "/cliente/pedido/"+this.idcliente;
  }

  imprimirRecibo(id){
    this.idpedido = id;

      if (this.idpedido  != null) {
          this._router.navigate(["pedido/recibo",this.idpedido]);
      }else{
        this._router.navigate(["/cliente/pedido",this.idcliente]);
      }
  }

   imprimirTarjeta(id,motivo){
    this.idpedido = id;
    this.idmotivo = motivo;
      if (this.idpedido  != null) {
          this._router.navigate(["pedido/tarjeta",this.idpedido,this.idmotivo]);
      }else{
        this._router.navigate(["/cliente/pedido",this.idcliente]);
      }
  }

  getAllMotivos(){
    this._route.params.subscribe(params=>{

      this._MotivoService.listarMotivos().subscribe(
          response =>{
            this.status = response['status'];
            if (this.status != "success") {
              this.status = "error";
            }else{
              this.motivos = response['data'];
               console.log(this.motivos);
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
}
