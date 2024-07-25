import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders, HttpResponse} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { map } from 'rxjs/operators';
import { GLOBAL } from './GLOBAL';

@Injectable()

export class PedidoService{

	//public url = "http://localhost:8000/floristeria1/backend/web";
	public url;
  public url2;
	constructor(
		private _http: HttpClient){
      this.url = GLOBAL.url;
      this.url2 = GLOBAL.url2;
    }

	create(pedido){
		let json = JSON.stringify(pedido);
		let params = "json="+json;

		let headers = new HttpHeaders().set('Content-Type','application/json');

		return this._http.post(this.url2+"/pedido/new", json,{headers: headers,observe: 'response'}).pipe(
      map((response: HttpResponse<any>) => {
        // Aquí puedes manejar la respuesta completa
        const status = response.status;
        const body = response.body;

        return { status, body };
      })
    );
	}

	listarPedidos( page = null){
		if (page == null) {
			page = 1;
		}
		return this._http.get(this.url+"/pedido/listar?page="+page);
	}

	Pedido(id){
		return this._http.get(this.url+"/pedido/"+id);
	}

	setPagado(id, pago){
		let pagar = {"pago": pago}
		let json = JSON.stringify(pagar);
		console.log("json" + json)
		let params = "json="+json;
		console.log(params, id);
		let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');

		return this._http.post(this.url+"/pedido/update/pagar/"+id, params,{headers: headers});
	}

	setEntregado(id, entregado){
		let entregar = {"entregado": entregado}
		let json = JSON.stringify(entregar);
		console.log("json" + json)
		let params = "json="+json;
		console.log(params, id);
		let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');

		return this._http.post(this.url+"/pedido/update/entregar/"+id, params,{headers: headers});
	}


	listarPedidoSearch( page = null, search = null){
		if (page == null) {
			page = 1;
		}
		let http : any;
		if (search == null) {
			http = this._http.get(this.url+"/pedido/search/?page="+page);
		} else{
			http = this._http.get(this.url+"/pedido/search/"+search+"?page="+page);
		}
		return http;
	}

	getPedidosCliente(page, id){
		if (page == null) {
			page = 1;
		}
		return this._http.get(this.url+"/cliente/pedidos/"+id+"?page="+page);
	}

	getPorPagar(page){
		if (page == null) {
			page = 1;
		}
		return this._http.get(this.url+"/pedido/por/pagar?page="+page);
	}

	getPorEntregar(page){
		if (page == null) {
			page = 1;
		}
		return this._http.get(this.url+"/pedido/por/entregar?page="+page);
	}

}
