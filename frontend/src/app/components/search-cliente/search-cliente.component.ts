import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { Cliente } from '../../model/cliente';
import { ClienteService } from '../../services/cliente.service';

@Component({
  selector: 'app-search-cliente',
  templateUrl: './search-cliente.component.html',
  styleUrls: ['./search-cliente.component.css'],
  providers: [ClienteService]
})
export class SearchClienteComponent implements OnInit {
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
  	constructor(private _ClienteService : ClienteService,
        private _route: ActivatedRoute,
        private _router: Router) { }

  	ngOnInit() {
  		this.cliente = new Cliente(1,"","","","","","");
      	this.cliente2 = new Cliente(1,"","","","","","");
      	this.searchClientes();
  	}

  	searchClientes(){
  		this._route.params.subscribe(params=>{
      	let search = params["search"];

      	if (!search || search.trim().length == 0) {
      		search = null;
      		this._router.navigate(["/home"]);
      	}
      	let page = +params["page"];
      	if (!page) {
        	page = 1;
      	}

      	this._ClienteService.listarClienteSearch(page, search).subscribe(
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
          	});
    	});

  	}

  	searchRute(){
      if (this.searchString != null) {
          this._router.navigate(["cliente/search",this.searchString]);
      }else{
        this._router.navigate(["/home"]);
      }
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
          this.status = response['status'];
          console.log(cliente);
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
      window.location.href = "/cliente";
      console.log("cliente creado");
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
    window.location.href = "/cliente/search/"+this.searchString;
  }

  clientePedido(id){
      if (id != null) {
          this._router.navigate(["cliente/pedido",id]);
      }else{
        this._router.navigate(["/home"]);
      }
  }
}
