package implementations;

import interfaces.GeneratorInterface;
import interfaces.NumberRemoverInterface;
import interfaces.ValidatorInterface;
import java.util.Random;

public class Generator implements GeneratorInterface {
    
    private ValidatorInterface validator;
    private NumberRemoverInterface numberRemover;

    private int[][] grid = new int[9][9];
    private int[] coreNumbers = {1, 2, 3, 4, 5, 6, 7, 8, 9};
    private int[] temp = new int[9];
    
    public Generator(ValidatorInterface validator, NumberRemoverInterface numberRemover) {
        this.validator = validator;
        this.numberRemover = numberRemover;
    }
    
    @Override
    public int[][] generateSolution(int numbersTobeRemoved) {
        
        // Fill array from 1 to 9 that comply with sudoku rules in rows, columns and subgrid
        for (int i = 0; i < grid.length; i++) {
            for (int j = 0; j < grid[i].length; j++) {
                
                switch (i) {
                    case 0:
                        fillTemp(0);
                        break;
                    case 1:
                        fillTemp(6);
                        break;
                    case 2:
                        fillTemp(3);
                        break;
                    case 3:
                        fillTemp(8);
                        break;
                    case 4:
                        fillTemp(5);
                        break;
                    case 5:
                        fillTemp(2);
                        break;
                    case 6:
                        fillTemp(7);
                        break;
                    case 7:
                        fillTemp(4);
                        break;
                    case 8:
                        fillTemp(1);
                        break;
                }
                this.grid[i][j] = this.temp[j];
            }   
        }
        
        // Swop random number pairs in each row
        Random r = new Random();
        
        int p1_x = r.nextInt((3 - 1) + 1) + 1;
        int p1_y = r.nextInt((6 - 4) + 1) + 4;
        
        int p2_x = p1_y;
        int p2_y = r.nextInt((9 - 7) + 1) + 7;
        
        while (p2_x == p1_y) {
            p2_x = r.nextInt((6 - 4) + 1) + 4;
        }
        
        for (int i = 0; i < grid.length; i++) {
            for (int j = 0; j < grid.length; j++) {
                
                // Number pairs to swop
                if (grid[i][j] == p1_x) {
                    grid[i][j] = p1_y;
                } else if (grid[i][j] == p1_y) {
                    grid[i][j] = p1_x;
                }
                
                if (grid[i][j] == p2_x) {
                    grid[i][j] = p2_y;
                } else if (grid[i][j] == p2_y) {
                    grid[i][j] = p2_x;
                }
                                
            }
        }
        
        // Return grid efter passing through validator and number remover
        return this.numberRemover.removeNumbers(this.validator.validateSudoku(this.grid), numbersTobeRemoved);
    }
    
    public void fillTemp(int startIndex) {
        
        // Select where array starts from
        int x = startIndex;
        
        // Fill the rest, if it reaches 9, start over from 1
        for (int i = 0; i < temp.length; i++) {
            
            temp[i] = this.coreNumbers[x];
            
            if (x == 8) {
                x = 0;
            } else {
                x++;
            }
        }
    }
    
}
