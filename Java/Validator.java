package implementations;

import interfaces.ValidatorInterface;
import java.util.Arrays;

public class Validator implements ValidatorInterface {

    private boolean isValid = true;
    private int[] coreNumbers = {1, 2, 3, 4, 5, 6, 7, 8, 9};
    private int[] tempNumbers = new int[9];
    private int count = 0;

    @Override
    public int[][] validateSudoku(int[][] array) {

        // Check each horisontal row
        for (int i = 0; i < array.length; i++) {
            for (int j = 0; j < array[i].length; j++) {

                this.tempNumbers[j] = array[i][j];

                // Check if tempNumbers are full, validate, clean and run next row
                if (count == 8) {
                    // Print each row
                    System.out.println(Arrays.toString(this.tempNumbers));
                    Arrays.sort(this.tempNumbers);

                    if (Arrays.equals(this.coreNumbers, this.tempNumbers)) {
                        continueCheck("Midway check row above: ");
                        Arrays.fill(this.tempNumbers, 0);
                        this.count = -1;
                    } else {
                        this.isValid = false;
                        continueCheck("Midway check row above: ");
                    }
                }
                this.count++;
            }
        }
        continueCheck("All horisontal rows: ");
        System.out.println("---");

        
        // Check vertical columns
        for (int i = 0; i < array.length; i++) {
            for (int j = 0; j < array[i].length; j++) {

                this.tempNumbers[j] = array[j][i];

                // Check if tempNumbers are full, validate, clean and run next column
                if (count == 8) {
                    // Print each column
                    for (int k = 0; k < array.length; k++) {
                        System.out.println(this.tempNumbers[k]);
                    }
                    Arrays.sort(this.tempNumbers);

                    if (Arrays.equals(this.coreNumbers, this.tempNumbers)) {
                        continueCheck("Midway check column above: ");
                        Arrays.fill(this.tempNumbers, 0);
                        this.count = -1;
                    } else {
                        this.isValid = false;
                        continueCheck("Midway check column above: ");
                    }
                }
                this.count++;
            }
        }
        continueCheck("All vertical columns: ");
        System.out.println("---");

        
        // Check each subgrid blocks, starting from top-left corner
        subGridBoxCheck(array, 0, 0);
        subGridBoxCheck(array, 0, 3);
        subGridBoxCheck(array, 0, 6);

        subGridBoxCheck(array, 3, 0);
        subGridBoxCheck(array, 3, 3);
        subGridBoxCheck(array, 3, 6);

        subGridBoxCheck(array, 6, 0);
        subGridBoxCheck(array, 6, 3);
        subGridBoxCheck(array, 6, 6);

        continueCheck("All subgrid boxes: ");
        
        
        // Return boolean
        //return this.isValid;
        
        // If Sudoku is a valid one, return this. Else return an empty array
        if (this.isValid == true) {
            return array;
        } else {
            int[][] empty = new int[9][9];
            
            return empty;
        }
    }

    public void continueCheck(String message) {
        if (this.isValid == false) {
            System.out.println(message + this.isValid);
            System.exit(0);
        } else {
            System.out.println(message + this.isValid);
        }
    }

    public void subGridBoxCheck(int[][] array, int x, int y) {

        this.tempNumbers[0] = array[x][y];
        this.tempNumbers[1] = array[x][y + 1];
        this.tempNumbers[2] = array[x][y + 2];

        this.tempNumbers[3] = array[x + 1][y];
        this.tempNumbers[4] = array[x + 1][y + 1];
        this.tempNumbers[5] = array[x + 1][y + 2];

        this.tempNumbers[6] = array[x + 2][y];
        this.tempNumbers[7] = array[x + 2][y + 1];
        this.tempNumbers[8] = array[x + 2][y + 2];

        for (int i = 0; i < this.tempNumbers.length; i++) {
            if (i == 2 || i == 5) {
                System.out.println(this.tempNumbers[i]);
            } else {
                System.out.print(this.tempNumbers[i]);
            }
            
        }
        System.out.println("");
        Arrays.sort(this.tempNumbers);

        if (Arrays.equals(this.coreNumbers, this.tempNumbers)) {
            continueCheck("Midway check subgrid above: ");
            Arrays.fill(this.tempNumbers, 0);
        } else {
            this.isValid = false;
            continueCheck("Midway check subgrid above: ");
        }
    }

}
