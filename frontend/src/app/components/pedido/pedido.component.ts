import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Cliente } from '../../model/cliente';
import { Pedido } from '../../model/pedido';
import { Dedicatoria } from '../../model/dedicatoria';
import { Motivo } from '../../model/motivo';
import { ClienteService } from '../../services/cliente.service';
import { PedidoService } from '../../services/pedido.service';
import { MotivoService } from '../../services/motivo.service';
import * as moment from 'moment';

@Component({
  selector: 'pedido',
  templateUrl: './pedido.component.html',
  styleUrls: ['./pedido.component.css'],
  providers: [ClienteService, PedidoService , MotivoService]
})
export class PedidoComponent implements OnInit {
	public titulo = "Crear pedido"
	public cliente;
	public status;
	public clientes;
	public errorMessage;
  public pedido;
  public date : Date = new Date();
  public date2: Date = new Date();
  public motivos;

  	constructor(private _ClienteService : ClienteService,
        private _PedidoService : PedidoService,
        private _MotivoService : MotivoService,
        private _route: ActivatedRoute,
        private _router: Router) { }

  	ngOnInit() {
  		this.cliente = new Cliente(1,"","","","","","");

      console.log(this.date2);
      this.pedido = new Pedido(1,"","","",false,0,0,this.date, this.date,moment(this.date2).format("YYYY-MM-DD"),"","","","","",false,this.date,"");
  		this.getAllClientes();
      this.getAllMotivos();
  	}

  	 getAllClientes(){
    this._route.params.subscribe(params=>{

      this._ClienteService.listarClientespedido().subscribe(
          response =>{
            this.status = response['status'];
            if (this.status != "success") {
              this.status = "error";
            }else{
              this.clientes = response['data'];
              console.log(this.clientes);
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

  newPedido(){
        let pedido = this.pedido;
        this._PedidoService.create(this.pedido).subscribe(
        response =>{
          this.status = response.status;
          console.log(pedido);
          if (this.status != '201') {
            this.status = "error";
          }else{
            this.pedido = response.body;
            console.log(this.pedido);
          }
        },
        error =>{
          this.errorMessage = <any>error;
          if (this.errorMessage != null) {
            console.log(this.errorMessage.message);
            alert("Error en la peticion");
          }
        }
        );
      window.location.href = "/";
      console.log("pedido creado");
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
