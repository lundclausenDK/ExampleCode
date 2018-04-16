package generator;

public class Generator {
    
    private int[][] grid = new int[9][9];
    private int[] coreNumbers = {1, 2, 3, 4, 5, 6, 7, 8, 9};
    private int[] temp = new int[9];
    
    public int[][] generateSolution() {
        
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
        
        // Swop number pairs in each row
        
        
        
        return this.grid;
    }
    
    void fillTemp(int startIndex) {
        
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
