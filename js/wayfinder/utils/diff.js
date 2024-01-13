export function getDiffPaths(obj1, obj2, path = '') {
  const diff = {};

  for (const prop in obj1) {
    if (prop in obj2) {
      const newPath = path ? `${path}.${prop}` : prop;

      if (Array.isArray(obj1[prop]) && Array.isArray(obj2[prop])) {
        const nestedDiff = getArrayDiffPaths(obj1[prop], obj2[prop], newPath);
        if (Object.keys(nestedDiff).length > 0) {
          Object.assign(diff, nestedDiff);
        }
      } else if (typeof obj1[prop] === 'object' && typeof obj2[prop] === 'object') {
        const nestedDiff = getDiffPaths(obj1[prop], obj2[prop], newPath);
        if (Object.keys(nestedDiff).length > 0) {
          Object.assign(diff, nestedDiff);
        }
      } else if (obj1[prop] !== obj2[prop]) {
        diff[newPath] = [obj1[prop], obj2[prop]];
      }
    } else {
      const newPath = path ? `${path}.${prop}` : prop;
      diff[newPath] = [obj1[prop], undefined];
    }
  }

  for (const prop in obj2) {
    if (!(prop in obj1)) {
      const newPath = path ? `${path}.${prop}` : prop;
      diff[newPath] = [undefined, obj2[prop]];
    }
  }

  return diff;
}

////////////////////////////////////////////////////////////////
////////// GET DIFF IN TWO ARRAYS //////////////////////////////
////////////////////////////////////////////////////////////////
export function getArrayDiffPaths(arr1, arr2, path = '') {
  const diff = {};

  for (let i = 0; i < arr1.length || i < arr2.length; i++) {
    if (i < arr1.length && i < arr2.length) {
      const newPath = `${path}[${i}]`;

      if (Array.isArray(arr1[i]) && Array.isArray(arr2[i])) {
        const nestedDiff = getArrayDiffPaths(arr1[i], arr2[i], newPath);
        if (Object.keys(nestedDiff).length > 0) {
          Object.assign(diff, nestedDiff);
        }
      } else if (typeof arr1[i] === 'object' && typeof arr2[i] === 'object') {
        const nestedDiff = getDiffPaths(arr1[i], arr2[i], newPath);
        if (Object.keys(nestedDiff).length > 0) {
          Object.assign(diff, nestedDiff);
        }
      } else if (arr1[i] !== arr2[i]) {
        diff[newPath] = [arr1[i], arr2[i]];
      }
    } else if (i < arr1.length) {
      const newPath = `${path}[${i}]`;
      diff[newPath] = [arr1[i], undefined];
    } else if (i < arr2.length) {
      const newPath = `${path}[${i}]`;
      diff[newPath] = [undefined, arr2[i]];
    }
  }

  return diff;
}


export function isEmptyObject(obj) {
  return Object.keys(obj).length === 0;
}