<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Paises;
use App\Models\tipo_cargas;
use App\Models\User;
use App\Models\Incoterm;
use App\Models\Contenedores;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\Validator;
use App\Models\tarifaGruapl;

class ColombiaController extends Controller
{
   
    public function index()
    {
        $cotizaciones = Cotizaciones::with('carga')->get(); 
        //return view('admin.calculadoras.colombia.grupal.index',compact('cotizaciones'));
        return $cotizaciones;
       
    }

    public function create(Request $request)
    {

        $idModalidad=$request->input('modalidad');
        $modalidad = Modalidades::findOrFail($idModalidad);
        $idPais = $request->input('pais');
        $pais=Paises::findOrFail($idPais);
        
        $mensajes =[
            'modalidad' => $modalidad,
            'paises' => $pais,
          
        ];
        if( $modalidad->id=="3"){
            return view('admin.calculadoras.colombia.grupal.create',$mensajes);
        }elseif ( $modalidad->id=="1") {
            return view('admin.calculadoras.colombia.fcl',$mensajes);
        }else{
            return view('admin.calculadoras.colombia.lcl',$mensajes);
        }
    }
    
    public function store(Request $request)
    {

        $request->validate([
            'usuario_id'=>['required'],
            'producto' => ['required', 'string', 'max:25'],
            'peso' => ['required', 'ends_with:kg,KG'],
            'cargas_id'=>['required'],
            'direccion'=>['required','string', 'min:5'],
            'total_cartones'=>['required','numeric:0'],
            'volumen'=>['required','min:0','max:8','numeric:0'],
            'ciudad_entrega' => ['required'],
        ]);

        $grupal = new Cotizaciones() ;
        $volumen=$request->input('volumen');

        switch ($volumen) {
            case ($volumen>0 && $volumen<1):
                
                $datos = tarifaGruapl::findOrFail(1);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=1 && $volumen<2):
                
                $datos = tarifaGruapl::findOrFail(2);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=2 && $volumen<3):
                
                $datos = tarifaGruapl::findOrFail(3);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=3 && $volumen<4):
                
                $datos = tarifaGruapl::findOrFail(4);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;    
            case ($volumen>=4 && $volumen<5):
                
                $datos = tarifaGruapl::findOrFail(5);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=5 && $volumen<6):
                
                $datos = tarifaGruapl::findOrFail(6);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=6 && $volumen<7):
               
                $datos = tarifaGruapl::findOrFail(7);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
            case ($volumen>=7 && $volumen<8):
                
                $datos = tarifaGruapl::findOrFail(8);
                $resultado =($volumen*$datos->tcbm)/1;
                
                break;
        }
        $grupal->usuario_id=$request->input('usuario_id');
        $grupal->pais_id=$request->input('pais');
        $grupal->modalidad_id=$request->input('modalidad');
        $grupal->producto=$request->input('producto');
        $grupal->peso=$request->input('peso');
        $grupal->cargas_id=$request->input('cargas_id');
        $grupal->direccion=$request->input('direccion');
        $grupal->total_cartones=$request->input('total_cartones');
        $grupal->volumen=$request->input('volumen');
        $grupal->ciudad_entrega=$request->input('ciudad_entrega');
        $grupal->proceso='2';
        $grupal->total=$resultado;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();
      
        return redirect()->route('admin.colombia.edit',$data);
       
    }

  
    public function show($id)
    {
        
    }

   
    public function edit($data)
    {
       
        $cotizacion = Cotizaciones::whereid($data)->with(['carga','pais','modalidad'])->first();
        //return $cotizacion;
        return view('admin.calculadoras.colombia.grupal.formulario',compact('cotizacion'));
    }

    
    public function update(Request $request, $id)
    {
        $datos=array(
            "proceso"=>'3'
        );
        
        Cotizaciones::whereid($id)->update($datos);
        //return response()->json($datos);
        return redirect('colombia')->with('mensaje','Cotizacion Actualizado');
        //return $datos;
    }

   
    public function destroy($id)
    {
        //
    }
}
