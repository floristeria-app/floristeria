import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Pedido } from '../../model/pedido';
import { PedidoService } from '../../services/pedido.service';


@Component({
  selector: 'app-porentregar',
  templateUrl: './porentregar.component.html',
  styleUrls: ['./porentregar.component.css'],
  providers: [PedidoService]
})
export class PorentregarComponent implements OnInit {
	  public pedidos;
	  public status;
	  public pages;
	  public pagePrev;
	  public pageNext;
	  public errorMessage;
	  public searchString;
  	public titulo = "Buscar Pedido:";
    public pedido2;
    public status_get_pedido;
    public date : Date = new Date() ;
    public idpedido;
    public idmotivo;

    constructor(private _PedidoService : PedidoService,
        private _route: ActivatedRoute,
        private _router: Router) { }

    ngOnInit() {
      this.pedido2 = new Pedido(1,"","","",false,1,1,this.date, this.date,this.date,"","","","","",false,this.date,"");
  	  this.listPedidoPorEntregar();
    }

    getPedido(id){
        this._route.params.subscribe(
        params =>{

        //let id = + params["id"];

        this._PedidoService.Pedido(id).subscribe(
          response => {
            this.pedido2 = response['data'];
            console.log(this.pedido2);
            this.status_get_pedido = response['status'];

            if (this.status_get_pedido != 'success') {
              this._router.navigate(["/pedido/porentregar"]);
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

  	listPedidoPorEntregar(){
    this._route.params.subscribe(params=>{
      let page = +params["page"];
      if (!page) {
        page = 1;
      }

      this._PedidoService.getPorEntregar(page).subscribe(
          response =>{
            this.status = response['status'];
            if (this.status != "success") {
              this.status = "error";
            }else{
              this.pedidos = response['data'];
               console.log(this.pedidos);
              this.pages = [];
              for (let i = 0; i < response['total_pages']; ++i) {
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
          }
        );
    });

  }

  porentregar(){
      this._router.navigate(["pedido/porentregar"]);

  }

  porpagar(){
          this._router.navigate(["pedido/porpagar"]);
  }

  search(){
      if (this.searchString != null) {
          this._router.navigate(["pedido/search",this.searchString]);
      }else{
        this._router.navigate(["/pedido/porentregar"]);
      }
  }

  setPagado(id, value){
    this._route.params.subscribe(params =>{
        this._PedidoService.setPagado(id, value).subscribe(
          response =>{
            this.status = response['status'];
            this._router.navigate(["/pedido/porentregar"]);
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
    window.location.href = "/pedido/porentregar";
  }

  setEntregado(id, value){
     this._route.params.subscribe(params =>{
        this._PedidoService.setEntregado(id, value).subscribe(
          response =>{
            this.status = response['status'];
            this._router.navigate(["/pedido/porentregar"]);
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
     window.location.href = "/pedido/porentregar";
  }

  imprimirRecibo(id){
    this.idpedido = id;

      if (this.idpedido  != null) {
          this._router.navigate(["pedido/recibo",this.idpedido]);
      }else{
        this._router.navigate(["/pedido/porentregar"]);
      }
  }

  imprimirTarjeta(id,motivo){
    this.idpedido = id;
    this.idmotivo = motivo;
      if (this.idpedido  != null) {
          this._router.navigate(["pedido/tarjeta",this.idpedido,this.idmotivo]);
      }else{
        this._router.navigate(["/pedido/porentregar"]);
      }
  }

}
