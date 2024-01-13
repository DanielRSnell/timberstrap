export function generateUniqueId() {
  // Generate a UUID (Universally Unique Identifier)
  return 'id_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

// ************************************************************* //
// ************************************************************* // 
// ***************  TREE HELPERS FUNCTIONS ********************* // 
// ************************************************************* // 
// ************************************************************* //


////////////////////////////////////////////////////////////////
////////// CREATE A RANODM ID STRING. //////////////////////////
////////////////////////////////////////////////////////////////
export function makeid(length) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }
  return result;
}