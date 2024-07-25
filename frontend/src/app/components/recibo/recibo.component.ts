import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Pedido } from '../../model/pedido';
import { PedidoService } from '../../services/pedido.service';

@Component({
  selector: 'app-recibo',
  templateUrl: './recibo.component.html',
  styleUrls: ['./recibo.component.css'],
  providers: [PedidoService]
})
export class ReciboComponent implements OnInit {
 	public idpedido;
 	public fecharecibo = new Date().toDateString();
 	public recibi;
 	public status;
 	public pedido = null;
 	public errorMessage;
 	public date : Date = new Date();
 	public idcliente = null;
 	public pedido2 = null;
 	public status_get_pedido;

  	constructor(private _PedidoService : PedidoService,
        private _route: ActivatedRoute,
        private _router: Router) {
         }

  	ngOnInit() {
  		this.pedido2 = new Pedido(1,"","","",false,1,1,this.date, this.date,this.date,"","","","",this.idcliente,false,this.date,"");
  		this.getPedido();
  		console.log(this.pedido);
  	}



  	getPedido(){
    this._route.params.subscribe(
        params =>{

        let id = + params["id"];

        this._PedidoService.Pedido(id).subscribe(
          response => {
            this.pedido2 = response['data'];
            console.log(this.pedido2);
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

}
