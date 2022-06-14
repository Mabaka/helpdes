
var isActiveOneOfSubMenu = false;
var isActiveOneOfSubMenu2 = false;

var lastPressedSubMenu = "";
var lastPressedSubMenu2 = "";

function showSubMenu(event) {


    var subMenu = event.srcElement.nextSibling.nextSibling;

    if (subMenu == null) {
        subMenu = event.srcElement.nextSibling;
    }

    if (isActiveOneOfSubMenu) {

        lastPressedSubMenu.style.display = 'none';

    }

    if (lastPressedSubMenu == subMenu) {
        lastPressedSubMenu.style.display = 'none';
        lastPressedSubMenu = "";
        isActiveOneOfSubMenu = false;
        return;
    }

    subMenu.style.display = 'inline-block';
    subMenu.style.left = '104%';
    subMenu.style.top = '0';

    lastPressedSubMenu = subMenu;

    isActiveOneOfSubMenu = true;

    console.log(lastPressedSubMenu);

}

function showSubMenu2(event) {

    var subMenu2 = event.srcElement.nextSibling.nextSibling;

    if (subMenu2 == null) {
        subMenu2 = event.srcElement.nextSibling;
    }

    if (isActiveOneOfSubMenu2) {

        lastPressedSubMenu2.style.display = 'none';

    }

    if (lastPressedSubMenu2 == subMenu2) {
        lastPressedSubMenu2.style.display = 'none';
        lastPressedSubMenu2 = "";
        isActiveOneOfSubMenu2 = false;
        return;
    }

    subMenu2.style.display = 'inline-block';
    subMenu2.style.left = '102.2%';
    subMenu2.style.top = '0';

    lastPressedSubMenu2 = subMenu2;

    isActiveOneOfSubMenu2 = true;
}
