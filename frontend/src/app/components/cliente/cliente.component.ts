import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Cliente } from '../../model/cliente';
import { ClienteService } from '../../services/cliente.service';

@Component({
  selector: 'app-cliente',
  templateUrl: './cliente.component.html',
  styleUrls: ['./cliente.component.css'],
  providers: [ClienteService]
})
export class ClienteComponent implements OnInit {
	public titulo = "Buscar Cliente: ";
  public hrcliente;
  public cliente;
  public cliente2;
  public status;
  public errorMessage;
  public clientes;
  public pages;
  public pagePrev = 1;
  public pageNext = 1;
  public status_get_cliente;
  public searchString;
  	constructor(
        private _ClienteService : ClienteService,
        private _route: ActivatedRoute,
        private _router: Router
        ) { }


  	ngOnInit() {
      this.cliente = new Cliente(1,"","","","","","");
      this.cliente2 = new Cliente(1,"","","","","","");

      this.getAllClientes();

  	}

  	creaCliente(value: string){
  		this.hrcliente = value;
  	}
    getCliente(id, value){
      this.hrcliente = value;

      this._route.params.subscribe(
        params =>{

        //let id = + params["id"];

        this._ClienteService.getCliente(id).subscribe(
          response => {
            this.cliente2 = response['data'];
            console.log(this.cliente2);
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

    newCliente(){

        let cliente = this.cliente;
        this._ClienteService.create(this.cliente).subscribe(
        response =>{
          console.log(response.status);
          this.status = response['status'];
          console.log(cliente);
          if (this.status != '201') {
            this.status = "error";
          }else{
            this.cliente = response.body;
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
      //window.location.href = "/cliente";
      console.log("cliente creado");
    }

    getAllClientes(){
    this._route.params.subscribe(params=>{
      let page = +params["page"];
      if (!page) {
        page = 1;
      }

      this._ClienteService.listarClientes(page).subscribe(
          response =>{
            this.status = response['status'];
            if (this.status != "success") {
              this.status = "error";
            }else{
              this.clientes = response['data'];
               console.log(this.clientes);
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

  editarCliente(id, value){
    this._route.params.subscribe(params =>{
        this._ClienteService.editCliente(this.cliente2, id).subscribe(
          response =>{
            this.status = response['status'];
            this._router.navigate(["/cliente"]);
            this.hrcliente = value;
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
    window.location.href = "/cliente";
  }

  search(){
      if (this.searchString != null) {
          this._router.navigate(["cliente/search",this.searchString]);
      }else{
        this._router.navigate(["/home"]);
      }
  }

  clientePedido(id){
      if (id != null) {
          this._router.navigate(["cliente/pedido",id]);
      }else{
        this._router.navigate(["/home"]);
      }
  }
}
