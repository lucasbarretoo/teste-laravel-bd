<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use function GuzzleHttp\Promise\all;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($contato_id = null)
    {
        /**
        * Realiza busca dos dados no banco de dados 
        * INICIO*/
        $aDadosContatos = Contato::all();

        $routeForm = 'gravar_contato';
        $routeEditContato = 'editar_contato';
        $routeDeleteContato = 'excluir_contato';

        $oContato = new Contato;
        // dd($contato_id);
        if($contato_id){
            $oContato = Contato::find($contato_id);
            if(Route::currentRouteName() == $routeEditContato){
                return json_encode($oContato);
            }
        }

        $compact[] = 'aDadosContatos';
        $compact[] = 'routeForm';
        $compact[] = 'oContato';
        $compact[] = 'routeEditContato';
        $compact[] = 'routeDeleteContato';

        return view('home', compact($compact));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gravarContato(Request $request){

        /**
         * Validando CPF
         */
        if(!validaCPF($request->cpf_contato)){
          $msg ='Não foi possível registrar contato. CPF ou CNPJ inválido.';
          $status = 'error';
        }else{

            /**
             * Insere ou atualiza um contato 
             */
            if($request->contato_id){
                $oContato = Contato::find($request->contato_id);
            }else{
                $oContato = new Contato;
            }
            $oContato->nome = $request->nome_contato;
            $oContato->cpf = $request->cpf_contato;
            $oContato->email = $request->email_contato;
            $oContato->telefone = $request->telefone_contato;
            $oContato->principal = $request->principal_contato ? 1 : 0;
            
            if($oContato->save()){
                $msg ='Contato registrado com sucesso.';
                $status = 'success';
            }
            /**
             * Realiza busca de todos os contatos no banco de dados 
             */
            $aContatos = Contato::all();
    
            /**
             * Inclui rotas de edição e exclusão
             */
            foreach ($aContatos as $key => $contato) {
                $aContatos[$key]['routeEdit'] = route('editar_contato', $contato->contato_id);
                $aContatos[$key]['routeDelete'] = route('excluir_contato', $contato->contato_id);
            }
            
            $aRetorno = $aContatos;
        }
        $aRetorno['msg'] = $msg;
        $aRetorno['status'] = $status;
        return json_encode($aRetorno);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excluir(Request $request){

        /**
         * Insere ou atualiza um contato 
         */
        $oContato = Contato::find($request->contato_id);
        if($oContato->contato_id && $oContato->delete()){
            $msg = 'Contato excluído com sucesso.';
            $status = 'success';
        }else{
            $msg = 'Falha ao excluir contato.';
            $status = 'error';
        }

        /**
         * Realiza busca de todos os contatos no banco de dados 
         */
        /**
         * Realiza busca de todos os contatos no banco de dados 
         */
        $aContatos = Contato::all();
        
        /**
         * Inclui rotas de edição e exclusão
         */
        foreach ($aContatos as $key => $contato) {
            $aContatos[$key]['routeEdit'] = route('editar_contato', $contato->contato_id);
            $aContatos[$key]['routeDelete'] = route('excluir_contato', $contato->contato_id);
        }
        $aRetorno = $aContatos;
        $aRetorno['msg'] = $msg;
        $aRetorno['status'] = $status;
        return json_encode($aRetorno);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
