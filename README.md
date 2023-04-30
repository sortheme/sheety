# sheety
a simple php class to use sheety api (google sheet)
# how to use
1. include sheety-api-class.php in your php script

    > include sheety-api-class.php
    
2. create an object from api class

    > $sheety_obj = new SorthSheety\api();
    
3. set required atts

    > $sheety_obj->set_base_url(URL OF YOUR PROJECT);
    
    > $sheety_obj->set_project(NAME OF PROJECT);
    
    > $sheety_obj->set_sheet(NAME OF DESIRED SHEET);
    
    > $sheety_obj->set_authorization( if using authorization set here);
    
4. use object methods to communicate with sheety web service
    
    > $sheety_obj->get_sheet_data()
    
    > $sheety_obj->get_sheet_row($id)

    > $sheety_obj->filter_sheet_rows($filters)

    > $sheety_obj->add_new_row_to_sheet($fields)

    > $sheety_obj->update_row_in_sheet($fields, $id)

    > $sheety_obj->delete_row($id)
