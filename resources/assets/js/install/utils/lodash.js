/**
 * Created by admin on 2017/9/6.
 */
import _ from 'lodash'

function findDeep(array_of_objects, condition , children_by = 'children') {
    let found = false;
    if (!array_of_objects) { return found; }

    found = _.some(array_of_objects , condition)
    if (found) { return found;}

    for (const [index, object] of array_of_objects.entries()) {
        found = _.has(object ,children_by) && findDeep(object[children_by] , condition);
        if (found) {
            break;
        }
    }

    return found;
}

function flatDeep(array_of_objects, children_by = 'children') {
    let flattened = [];
    if (!array_of_objects) { return flattened; }

    _.each(array_of_objects, (object)=>{
        let hasChildren = _.has(object ,children_by)
        if (hasChildren) {
            let children  = _.get(object , children_by);
            let object_without_children_property = _.omit(object, children_by)

            flattened.push(object_without_children_property)
            let flat_children = flatDeep(children, children_by = 'children');
            flattened = _.concat(flattened , flat_children);
        }else{
            flattened.push(object)
        }
    })


    return flattened;
}


_.mixin({'findDeep':findDeep}, { 'chain': false })
_.mixin({'flatDeep':flatDeep}, { 'chain': false })

export default _