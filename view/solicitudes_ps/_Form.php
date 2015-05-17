<?php  include("../lib/functions.php"); ?>
<script type="text/javascript" src="js/app/evt_form_solicitudes.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>

<div class="div_container">
<h6 class="ui-widget-header">Registro de oficina</h6>

<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="alumno" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 750px; " align="center">
            <fieldset class="ui-corner-all" >
                <legend>Datos</legend>  
               <table border="0" cellpadding="3" cellspacing="1" style="background-color:#fff;" >
                   <tr class="fil">
                      <td width="20%" align="left">
                        <span for="CodigoAlumno" ><strong>Codigo:</strong></label>
                      </td>
                      <td width="30%">
                        <input id="CodigoAlumno" name="CodigoAlumno" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->CodigoAlumno; ?>" readonly />                
                      </td>
                      <td width="20%" align="left">
                         <strong for="ApellidoPaterno" >Apellido Paterno:</strong>
                      </td>  
                      <td width="30%" >
                         <input id="ApellidoPaterno" name="ApellidoPaterno" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->ApellidoPaterno; ?>"  />                
                       </td>
                    </tr>
                    <tr class="fil">
                       <td> 
                         <strong for="ApellidoMaterno" align="right" >Apellido Materno:</strong>
                       </td> 
                       <td>
                         <input id="ApellidoMaterno" name="ApellidoMaterno" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->ApellidoMaterno; ?>"  />           
                       </td>
                       <td align="left">
                           <strong for="NombreAlumno"  >Nombre Alumno:</strong>
                       </td>
                       <td>
                           <input id="NombreAlumno" name="NombreAlumno" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->NombreAlumno; ?>"  />                
                       </td>
                     </tr>
                     <tr class="fil">
                       <td align="rigth">
              
                            <strong for="Direccion"  >Direccion:</strong>
                       </td> 
                       <td>
                            <input id="Direccion" name="Direccion" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Direccion; ?>"  />                
                        </td>   
                        <td>
                            <strong for="Email" class="labels" >Email:</strong>
                        </td>  
                        <td>
                            <input id="Email" name="Email" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Email; ?>"  />
                         </td>
                      </tr>
                      <tr class="fil">
                          <td align="left">
                                 <strong for="FechaNacimiento" class="labels" >Fecha Nacimiento:</strong>
                           </td>
                           <td>
                                 <input id="FechaNacimiento" name="FechaNacimiento" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->FechaNacimiento; ?>"  />                
                           </td>
                           <td>
                                <strong for="Telefono" class="labels" >Telefono:</strong>
                            </td> 
                            <td>
                                <input id="Telefono" name="Telefono" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Telefono; ?>"  />                
                            </td>        
                      </tr>
                      <tr class="fil">
                            <td> 
                                
                                
                               <strong for="TipoDocumento" class="labels" style="width: 130px;">Tipo Documento:</strong>
                           
                            </td>
                            <td>
                               
                                <select  id="TipoDocumento" name="TipoDocumento" style="width: 150px; border-radius: 4px; height: 31px;">>
                                    <option value="0">----</option>
                                    <option value="D.N.I." <?php if($obj->TipoDocumento=="D.N.I."){echo "selected";} ?>>DNI</option>
                                    <option value="pasaporte" <?php if($obj->TipoDocumento=="pasaporte"){echo "selected";} ?>>PASAPORTE</option>
                                    <option value="carnetextranjeria" <?php if($obj->TipoDocumento=="carnetextranjeria"){echo "selected";} ?>>Carnet Extranjeria</option>
                                </select>
                                
                            </td>
                            <td>
                                 <strong for="NumDocumento" class="labels" >Numero Documento:</strong>
                             </td>
                             <td>
                                 <input id="NumDocumento" name="NumDocumento" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->NumDocumento; ?>"  />                
                             </td>
                       </tr>
                       <tr class="fil">
                             <td>
                                 <strong for="FechaIngreso"  style="width: 120px">Fecha Ingreso:</strong>
                             </td>
                             <td>
                                 <input id="FechaIngreso" name="FechaIngreso" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->FechaIngreso; ?>"  />                
                             </td>
                             <td align="left">
                                <strong for="GrupoSangre" >Grupo Sangre:</strong>
                             </td>
                             <td>
                                <select name="GrupoSangre" id="GrupoSangre" style="width: 161px; border-radius: 4px; height: 31px">
                                <option value="">...</option>
                                <option value="O-" <?php if($obj->GrupoSangre=="O-"){echo "selected";} ?> >O-</option>
                                <option value="O+" <?php if($obj->GrupoSangre=="O+"){echo "selected";} ?> >O+</option>
                                <option value="A−" <?php if($obj->GrupoSangre=="A−"){echo "selected";} ?> >A−</option>
                                <option value="A+" <?php if($obj->GrupoSangre=="A+"){echo "selected";} ?> >A+</option>
                                <option value="B−" <?php if($obj->GrupoSangre=="B−"){echo "selected";} ?> >B−</option>
                                <option value="B+" <?php if($obj->GrupoSangre=="B+"){echo "selected";} ?> >B+</option>
                                <option value="AB−" <?php if($obj->GrupoSangre=="AB−"){echo "selected";} ?> >AB−</option>
                                <option value="AB+" <?php if($obj->GrupoSangre=="AB+"){echo "selected";} ?> >AB+</option>
                                
                                </select>
                             </td>
                       </tr>
                       
                       
                       <tr>
                              <td align="left">
                                <strong for="$iddepartamento">Departamento:</strong>
                              </td> 
                              <td>
                                  
                                  <?php echo $departamento;?>
                             
                              
                              </td>
                              <td align="left">
                                <strong for="provincia"  style="width: 80px">Provincia:</strong>
                              </td>
                              <td>
                                         <?php if($readonly==""){ ?>
                                                <select id="provincia" name="provincia" class="ui-corner-all text ui-widget-content" style="width: 161px;">
                                                  <option value="">...</option>
                                                </select>
                                                <?php } 
                                                else {
                                                    echo $provincia;
                                                }
                                                ?>
                              </td>
                       </tr> 
                       <tr>
                              <td align="left">
                                <strong for="distrito">Distito:</strong>
                              </td> 
                              <td>
                                  
                                  <?php if($readonly==""){ ?>
                                                <select id="distrito" name="distrito" class="ui-corner-all text ui-widget-content" style="width: 161px;">
                                                  <option value="">...</option>
                                                </select>
                                                <?php } 
                                                else {
                                                    echo $distrito;
                                                }
                                                ?>
                             
                              
                              </td>
                              <td align="left">
                                <strong for="Sexo"  style="width: 80px">Sexo:</strong>
                              </td>
                              <td>
                                  
                                <select name="Sexo" id="sexo">
                                <option value="">...</option>
                                <option value="M" <?php if($obj->Sexo=="M"){echo "selected";} ?> >MASCULINO</option>
                                <option value="F" <?php if($obj->Sexo=="F"){echo "selected";} ?> >FEMENINO</option>
                            </select>
                              
                              </td>
                       </tr> 
                       <tr class="fil">
                              <td align="left">
                                     <strong for="EstadoCivil" >EstadoCivil:</strong>
                               </td>
                               <td>
                                   
                               <!--  <input id="EstadoCivil" name="EstadoCivil" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->EstadoCivil; ?>"  />                
                                -->
                                
                                <select id="EstadoCivil" name="EstadoCivil">
                                    <option value="0">-----</option>
                                    <option value="S" <?php if($obj->EstadoCivil=="S"){echo "selected";} ?>>Soltero</option>
                                    <option value="C" <?php if($obj->EstadoCivil=="C"){echo "selected";} ?>>Casado</option>
                                    <option value="D" <?php if($obj->EstadoCivil=="D"){echo "selected";} ?>>Diborciado</option>
                                    <option value="V" <?php if($obj->EstadoCivil=="V"){echo "selected";} ?>>Viudo</option>
                                </select>
                               </td> 
                                    
                                <td align="left">
                                     <strong for="HijoTrabajador">HijoTrabajador:</strong>
                                </td>
                                <td>
                                    <input id="HijoTrabajador" name="HijoTrabajador" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->HijoTrabajador; ?>"  />                
                                </td>
                        </tr>     
                        <tr class="fil">
                                <td align="left">
                                   <strong for="EstadoAlumno" >EstadoAlumno:</strong>
                                </td>  
                                <td>
                                    
                                    <select id="EstadoAlumno" name="EstadoAlumno">
                                    <option value="0">-----</option>
                                    <option value="I" <?php if($obj->EstadoAlumno=="I"){echo "selected";} ?>>INACTIVO</option>
                                    <option value="A" <?php if($obj->EstadoAlumno=="A"){echo "selected";} ?>>ACTIVO</option>
                                   </select>
                                    
                                   <!--<input id="EstadoAlumno" name="EstadoAlumno" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->EstadoAlumno; ?>"  />                
                                -->
                                
                                
                                
                                </td>
                                <td align="left">
                                    <strong for="CodAlumnoSira" >CodAlumnoSira:</strong>
                                </td>
                                <td>
                                    <input id="CodAlumnoSira" name="CodAlumnoSira" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->CodAlumnoSira; ?>"  />                
                                </td>
                        </tr>
               
               
                        <tr class="fil">
                                <td align="left">
                                        <strong for="CodigoSemestreIngreso" >Semestre Ingreso:</strong>
                                </td> 
                                <td>
                                    <?php echo $semestreacademico;?>
                                       <!-- <input id="CodigoSemestreIngreso" name="CodigoSemestreIngreso" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->CodigoSemestreIngreso; ?>"  />                
                                            -->
                                </td>
                                <td align="left">
                                        <strong for="FechaEgreso" >FechaEgreso:</strong>
                                </td>    
                                <td>
                                        <input id="FechaEgreso" name="FechaEgreso" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->FechaEgreso; ?>"  />                
                                </td>       
                        </tr>
               
                        <tr class="fil">
                                <td align="left">
                                        <strong for="CodigoSemestreEgreso" >Semestre Egreso:</strong>
                                </td> 
                                <td>
                                        <?php echo $semestreacademico;?>                
                                </td>        
                                <td align="left">
                                        <strong for="CodigoSedeEscuela" >CodigoSedeEscuela:</strong>
                                </td >
                                <td>
                                        <input id="CodigoSedeEscuela" name="CodigoSedeEscuela" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->CodigoSedeEscuela; ?>"  />                
                                </td>
                        </tr>
               
                        <tr class="fil">
                                <td>
                                        <strong for="Foto" >Foto:</strong>
                                </td>   
                                <td>
                                        <input id="Foto" name="Foto" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Foto; ?>"  />                
                                 </td>
                                 <td>
                                        <strong for="Puesto" >Puesto:</strong>
                                 </td> 
                                 <td>
                                        <input id="Puesto" name="Puesto" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Puesto; ?>"  />                
                                 </td>
                        </tr>
                        <tr class="fil">
                                  <td>
                                        <strong for="FechaEstadoSituacional" >FechaEstadoSituacional:</strong>
                                   </td> 
                                   <td>
                                        <input id="FechaEstadoSituacional" name="FechaEstadoSituacional" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->FechaEstadoSituacional; ?>"  />                
                                    </td>
                                    <td>
                                        <strong for="CodNacionalidad">CodNacionalidad:</strong>
                                    </td> 
                                    <td>
                                        <input id="CodNacionalidad" name="CodNacionalidad" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->CodNacionalidad; ?>"  />                
                                    </td>    
                        </tr>
                 
                        <tr class="fil">
                                    <td>
                                        <strong for="Cobertura" >Cobertura:</strong>
                                    </td>
                                    <td>
                                        <input id="Cobertura" name="Cobertura" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->Cobertura; ?>"  />                
                                    </td>    
                                    <td>
                                        <strong for="CodigTipoColegio">Tipo Colegio:</strong>
                                    </td>
                                    <td>
                                        <?php echo $tipocolegio; ?>  
                                    </td>        
                        </tr>
                                <tr class="fil">
                                     <td>
                                            <strong for="CodigRegimen"  >Regimen</strong>
                                     </td>
                                     <td>
                                            <?php echo $regimencolegio; ?>  
                                     </td>     
                                     <td>    
                                            <strong for="CodigoModalidad" >Modalidad:</strong>
                                     </td>
                                     <td>
                                         <?php echo $modalidadingreso; ?> 
                                      </td>
                        </tr>
                        <tr class="fil">
                                    <td>
                                        <strong for="CodigoTipoIngreso"  >TipoIngreso:</strong>
                                    </td> 
                                    <td>
                                            <?php echo $tipoingreso; ?>  
                                    <td>
                                        <strong for="CodigoEstadoSituacional" class="labels" style="width: 70px" >EstadoSituacional:</strong>
                                    </td> 
                                    <td>
                                         <?php echo $estadosituacional; ?>  
                                    </td>
                        </tr>
                        <tr class="fil">
                                    <td>
                                            <strong for="CodigoFacultad" class="labels" style="width: 70px" >Facultad:</strong>
                                    </td>    
                                    <td>
                                            <?php echo $facultades; ?>  
                                    </td>
                                    <td>
                                            <strong for="CodigoEscuela" class="labels" style="width: 70px" >Escuela:</strong>
                                    </td> 
                                    <td>
                                        
                                            <?php if($readonly==""){ ?>
                                                <select id="CodigoEscuela" name="CodigoEscuela" class="ui-corner-all text ui-widget-content">
                                                  <option value="">...</option>
                                                </select>
                                                <?php } 
                                                else {
                                                    echo $escuelaprofesional;
                                                }
                                                ?>
                                               
                                        
                                    </td>
                  
                         </tr>
               </table>
      
                </div>
             </fieldset>
             <div class="contenido" style="margin:0 auto; width: 750px; " align="center">
             <fieldset class="ui-corner-all" >
                <legend>Accion</legend> 
                 <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=alumno" class="button">ATRAS</a>
                 </div>   
              </fieldset>
              </div>
        </div>
    </div>
</form>
